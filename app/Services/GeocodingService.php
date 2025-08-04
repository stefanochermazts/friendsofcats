<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    private const NOMINATIM_BASE_URL = 'https://nominatim.openstreetmap.org';
    private const USER_AGENT = 'FriendsOfCats/1.0';

    /**
     * Geocodifica un indirizzo e restituisce le coordinate
     */
    public function geocodeAddress(string $address, string $city, string $province, string $country = 'Italia'): ?array
    {
        try {
            // Costruisce l'indirizzo completo
            $fullAddress = $this->buildFullAddress($address, $city, $province, $country);
            
            // Effettua la richiesta all'API di Nominatim
            $response = Http::withHeaders([
                'User-Agent' => self::USER_AGENT,
                'Accept' => 'application/json',
            ])->get(self::NOMINATIM_BASE_URL . '/search', [
                'q' => $fullAddress,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
                'countrycodes' => 'it', // Limita ai risultati italiani
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                    return [
                        'latitude' => (float) $data[0]['lat'],
                        'longitude' => (float) $data[0]['lon'],
                        'formatted_address' => $data[0]['display_name'] ?? $fullAddress,
                        'confidence' => $this->calculateConfidence($data[0], $city, $province),
                    ];
                }
            }

            Log::warning('Geocodifica fallita per indirizzo: ' . $fullAddress);
            return null;

        } catch (\Exception $e) {
            Log::error('Errore durante la geocodifica: ' . $e->getMessage(), [
                'address' => $address,
                'city' => $city,
                'province' => $province,
            ]);
            return null;
        }
    }

    /**
     * Costruisce l'indirizzo completo per la geocodifica
     */
    private function buildFullAddress(string $address, string $city, string $province, string $country): string
    {
        $parts = array_filter([$address, $city, $province, $country]);
        return implode(', ', $parts);
    }

    /**
     * Calcola la confidenza del risultato basandosi sulla corrispondenza
     */
    private function calculateConfidence(array $result, string $city, string $province): float
    {
        $confidence = 0.0;
        $addressDetails = $result['address'] ?? [];

        // Controlla corrispondenza città
        if (isset($addressDetails['city']) && 
            strtolower(trim($addressDetails['city'])) === strtolower(trim($city))) {
            $confidence += 0.5;
        }

        // Controlla corrispondenza provincia
        if (isset($addressDetails['state']) && 
            strtolower(trim($addressDetails['state'])) === strtolower(trim($province))) {
            $confidence += 0.3;
        }

        // Se abbiamo un risultato, almeno una minima confidenza
        if ($confidence === 0.0) {
            $confidence = 0.2;
        }

        return min($confidence, 1.0);
    }

    /**
     * Verifica se le coordinate sono valide
     */
    public function isValidCoordinates(float $latitude, float $longitude): bool
    {
        return $latitude >= -90 && $latitude <= 90 && 
               $longitude >= -180 && $longitude <= 180;
    }

    /**
     * Calcola la distanza tra due coordinate (formula di Haversine)
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Raggio della Terra in km

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
} 