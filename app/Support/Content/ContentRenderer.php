<?php

declare(strict_types=1);

namespace App\Support\Content;

class ContentRenderer
{
    /**
     * Applica trasformazioni HTML lato server per i contenuti degli articoli.
     * - Converte blocchi in formato "pseudo-tabella" (header seguito da righe che iniziano con |)
     *   in una tabella HTML con classi Tailwind.
     */
    public static function render(string $html): string
    {
        return self::transformAutoTables($html);
    }

    private static function transformAutoTables(string $html): string
    {
        // Usa DOMDocument per lavorare su <p> sequenziali
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = false;

        // Wrappa in un container per gestire frammenti HTML
        $wrapped = '<div id="__root__">' . $html . '</div>';
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        /** @var \DOMElement|null $root */
        $root = $doc->getElementById('__root__');
        if (!$root) {
            return $html;
        }

        // Scansiona i figli e rileva sequenze <p> che rappresentano una tabella
        $i = 0;
        while ($i < $root->childNodes->length) {
            $node = $root->childNodes->item($i);
            if (!$node instanceof \DOMElement || strtolower($node->nodeName) !== 'p') {
                $i++;
                continue;
            }

            $firstText = trim(self::getNodeText($node));
            // Il primo paragrafo non deve iniziare con |
            if ($firstText === '' || str_starts_with($firstText, '|') === true) {
                $i++;
                continue;
            }

            // Raccogli righe successive che iniziano con |
            $rows = [];
            $j = $i + 1;
            while ($j < $root->childNodes->length) {
                $n = $root->childNodes->item($j);
                if ($n instanceof \DOMElement && strtolower($n->nodeName) === 'p') {
                    $txt = trim(self::getNodeText($n));
                    if (str_starts_with($txt, '|')) {
                        $rows[] = $txt;
                        $j++;
                        continue;
                    }
                }
                break; // si interrompe quando la sequenza termina
            }

            if (count($rows) >= 2) {
                // Costruisci tabella
                $table = self::buildTableElement($doc, $firstText, $rows);

                // Sostituisci i nodi: header + righe
                $replaceUntil = $j - 1;
                for ($k = $replaceUntil; $k >= $i; $k--) {
                    $root->removeChild($root->childNodes->item($k));
                }
                $root->insertBefore($table, $root->childNodes->item($i) ?: null);

                // Continua dopo la tabella
                $i++; // avanza oltre il nuovo nodo
                continue;
            }

            $i++;
        }

        // Ritorna l'HTML dei figli del root wrapper
        $result = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $result .= $doc->saveHTML($child);
        }
        return $result;
    }

    private static function getNodeText(\DOMNode $node): string
    {
        return preg_replace("/\s+/u", ' ', $node->textContent ?? '') ?? '';
    }

    private static function splitHeader(string $header, int $expectedCols): array
    {
        // Prova split per pipe, poi per 2+ spazi, infine per 1+ spazi
        foreach ([
            '/\s*\|\s*/u',
            '/\s{2,}/u',
            '/\s+/u',
        ] as $regex) {
            $parts = array_values(array_filter(array_map('trim', preg_split($regex, $header) ?: []), fn($v) => $v !== ''));
            if ($expectedCols === 0 || count($parts) === $expectedCols) {
                return $parts;
            }
        }
        return [];
    }

    private static function parseRow(string $row): array
    {
        // Righe tipo: | col1 | col2 | col3
        $row = trim($row);
        if (str_starts_with($row, '|')) {
            $row = substr($row, 1);
        }
        if (str_ends_with($row, '|')) {
            $row = substr($row, 0, -1);
        }
        $parts = array_map(fn($v) => trim($v), explode('|', $row));
        return array_values(array_filter($parts, fn($v) => $v !== ''));
    }

    private static function buildTableElement(\DOMDocument $doc, string $headerLine, array $rowLines): \DOMElement
    {
        $rows = array_map([self::class, 'parseRow'], $rowLines);
        $numCols = count($rows[0] ?? []);
        $headers = self::splitHeader($headerLine, $numCols);

        $table = $doc->createElement('table');
        $table->setAttribute('class', 'w-full table-auto border-collapse text-left my-6');

        if (!empty($headers)) {
            $thead = $doc->createElement('thead');
            $tr = $doc->createElement('tr');
            foreach ($headers as $h) {
                $th = $doc->createElement('th');
                $th->setAttribute('class', 'border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 px-3 py-2 font-semibold');
                $th->appendChild($doc->createTextNode($h));
                $tr->appendChild($th);
            }
            $thead->appendChild($tr);
            $table->appendChild($thead);
        }

        $tbody = $doc->createElement('tbody');
        foreach ($rows as $r) {
            $tr = $doc->createElement('tr');
            foreach ($r as $c) {
                $td = $doc->createElement('td');
                $td->setAttribute('class', 'border border-gray-200 dark:border-gray-800 px-3 py-2 align-top');
                $td->appendChild($doc->createTextNode($c));
                $tr->appendChild($td);
            }
            $tbody->appendChild($tr);
        }
        $table->appendChild($tbody);

        return $table;
    }
}


