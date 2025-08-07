<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Polje :attribute mora biti sprejeto.',
    'accepted_if' => 'Polje :attribute mora biti sprejeto, ko je :other :value.',
    'active_url' => 'Polje :attribute mora biti veljaven URL.',
    'after' => 'Polje :attribute mora biti datum po :date.',
    'after_or_equal' => 'Polje :attribute mora biti datum po ali enak :date.',
    'alpha' => 'Polje :attribute sme vsebovati samo črke.',
    'alpha_dash' => 'Polje :attribute sme vsebovati samo črke, številke, pomišljaje in podčrtaje.',
    'alpha_num' => 'Polje :attribute sme vsebovati samo črke in številke.',
    'array' => 'Polje :attribute mora biti matrika.',
    'before' => 'Polje :attribute mora biti datum pred :date.',
    'before_or_equal' => 'Polje :attribute mora biti datum pred ali enak :date.',
    'between' => [
        'array' => 'Polje :attribute mora imeti med :min in :max elementi.',
        'file' => 'Polje :attribute mora biti med :min in :max kilobajti.',
        'numeric' => 'Polje :attribute mora biti med :min in :max.',
        'string' => 'Polje :attribute mora biti med :min in :max znaki.',
    ],
    'boolean' => 'Polje :attribute mora biti pravilno ali napačno.',
    'confirmed' => 'Potrditev polja :attribute se ne ujema.',
    'current_password' => 'Geslo ni pravilno.',
    'date' => 'Polje :attribute mora biti veljaven datum.',
    'date_equals' => 'Polje :attribute mora biti datum enak :date.',
    'date_format' => 'Polje :attribute se ne ujema z obliko :format.',
    'decimal' => 'Polje :attribute mora imeti :decimal decimalnih mest.',
    'declined' => 'Polje :attribute mora biti zavrnjeno.',
    'declined_if' => 'Polje :attribute mora biti zavrnjeno, ko je :other :value.',
    'different' => 'Polje :attribute in :other morata biti različna.',
    'digits' => 'Polje :attribute mora biti :digits številk.',
    'digits_between' => 'Polje :attribute mora biti med :min in :max številkami.',
    'dimensions' => 'Polje :attribute ima neveljavne dimenzije slike.',
    'distinct' => 'Polje :attribute ima podvojeno vrednost.',
    'doesnt_end_with' => 'Polje :attribute se ne sme končati z eno od naslednjih: :values.',
    'doesnt_start_with' => 'Polje :attribute se ne sme začeti z eno od naslednjih: :values.',
    'email' => 'Polje :attribute mora biti veljaven e-poštni naslov.',
    'ends_with' => 'Polje :attribute se mora končati z eno od naslednjih: :values.',
    'enum' => 'Izbrani :attribute ni veljaven.',
    'exists' => 'Izbrani :attribute ni veljaven.',
    'file' => 'Polje :attribute mora biti datoteka.',
    'filled' => 'Polje :attribute mora imeti vrednost.',
    'gt' => [
        'array' => 'Polje :attribute mora imeti več kot :value elementov.',
        'file' => 'Polje :attribute mora biti večji od :value kilobajtov.',
        'numeric' => 'Polje :attribute mora biti večji od :value.',
        'string' => 'Polje :attribute mora biti večji od :value znakov.',
    ],
    'gte' => [
        'array' => 'Polje :attribute mora imeti :value elementov ali več.',
        'file' => 'Polje :attribute mora biti večji ali enak :value kilobajtov.',
        'numeric' => 'Polje :attribute mora biti večji ali enak :value.',
        'string' => 'Polje :attribute mora biti večji ali enak :value znakov.',
    ],
    'image' => 'Polje :attribute mora biti slika.',
    'in' => 'Izbrani :attribute ni veljaven.',
    'in_array' => 'Polje :attribute ne obstaja v :other.',
    'integer' => 'Polje :attribute mora biti celo število.',
    'ip' => 'Polje :attribute mora biti veljaven IP naslov.',
    'ipv4' => 'Polje :attribute mora biti veljaven IPv4 naslov.',
    'ipv6' => 'Polje :attribute mora biti veljaven IPv6 naslov.',
    'json' => 'Polje :attribute mora biti veljaven JSON niz.',
    'lowercase' => 'Polje :attribute mora biti z malimi črkami.',
    'lt' => [
        'array' => 'Polje :attribute mora imeti manj kot :value elementov.',
        'file' => 'Polje :attribute mora biti manjši od :value kilobajtov.',
        'numeric' => 'Polje :attribute mora biti manjši od :value.',
        'string' => 'Polje :attribute mora biti manjši od :value znakov.',
    ],
    'lte' => [
        'array' => 'Polje :attribute ne sme imeti več kot :value elementov.',
        'file' => 'Polje :attribute mora biti manjši ali enak :value kilobajtov.',
        'numeric' => 'Polje :attribute mora biti manjši ali enak :value.',
        'string' => 'Polje :attribute mora biti manjši ali enak :value znakov.',
    ],
    'mac_address' => 'Polje :attribute mora biti veljaven MAC naslov.',
    'max' => [
        'array' => 'Polje :attribute ne sme imeti več kot :max elementov.',
        'file' => 'Datoteka :attribute ne sme presegati :max kilobajtov.',
        'numeric' => 'Polje :attribute ne sme biti večji od :max.',
        'string' => 'Polje :attribute ne sme biti večji od :max znakov.',
    ],
    'max_digits' => 'Polje :attribute ne sme imeti več kot :max številk.',
    'mimes' => 'Polje :attribute mora biti datoteka tipa: :values.',
    'mimetypes' => 'Polje :attribute mora biti datoteka tipa: :values.',
    'min' => [
        'array' => 'Polje :attribute mora imeti vsaj :min elementov.',
        'file' => 'Polje :attribute mora biti vsaj :min kilobajtov.',
        'numeric' => 'Polje :attribute mora biti vsaj :min.',
        'string' => 'Polje :attribute mora biti vsaj :min znakov.',
    ],
    'min_digits' => 'Polje :attribute mora imeti vsaj :min številk.',
    'multiple_of' => 'Polje :attribute mora biti večkratnik od :value.',
    'not_in' => 'Izbrani :attribute ni veljaven.',
    'not_regex' => 'Oblika polja :attribute ni veljavna.',
    'numeric' => 'Polje :attribute mora biti številka.',
    'password' => [
        'letters' => 'Polje :attribute mora vsebovati vsaj eno črko.',
        'mixed' => 'Polje :attribute mora vsebovati vsaj eno veliko in eno malo črko.',
        'numbers' => 'Polje :attribute mora vsebovati vsaj eno številko.',
        'symbols' => 'Polje :attribute mora vsebovati vsaj en simbol.',
        'uncompromised' => 'Dano :attribute se je pojavilo v podatkovni kršitvi. Prosimo, izberite drugo :attribute.',
    ],
    'present' => 'Polje :attribute mora biti prisotno.',
    'prohibited' => 'Polje :attribute je prepovedano.',
    'prohibited_if' => 'Polje :attribute je prepovedano, ko je :other :value.',
    'prohibited_unless' => 'Polje :attribute je prepovedano, razen če je :other v :values.',
    'prohibits' => 'Polje :attribute prepoveduje prisotnost :other.',
    'regex' => 'Oblika polja :attribute ni veljavna.',
    'required' => 'Polje :attribute je obvezno.',
    'required_array_keys' => 'Polje :attribute mora vsebovati vnose za: :values.',
    'required_if' => 'Polje :attribute je obvezno, ko je :other :value.',
    'required_if_accepted' => 'Polje :attribute je obvezno, ko je :other sprejeto.',
    'required_unless' => 'Polje :attribute je obvezno, razen če je :other v :values.',
    'required_with' => 'Polje :attribute je obvezno, ko je prisoten :values.',
    'required_with_all' => 'Polje :attribute je obvezno, ko so prisotni :values.',
    'required_without' => 'Polje :attribute je obvezno, ko :values ni prisoten.',
    'required_without_all' => 'Polje :attribute je obvezno, ko nobeden od :values ni prisoten.',
    'same' => 'Polje :attribute in :other se morata ujemati.',
    'size' => [
        'array' => 'Polje :attribute mora vsebovati :size elementov.',
        'file' => 'Polje :attribute mora biti :size kilobajtov.',
        'numeric' => 'Polje :attribute mora biti :size.',
        'string' => 'Polje :attribute mora biti :size znakov.',
    ],
    'starts_with' => 'Polje :attribute se mora začeti z eno od naslednjih: :values.',
    'string' => 'Polje :attribute mora biti niz.',
    'timezone' => 'Polje :attribute mora biti veljaven časovni pas.',
    'unique' => ':attribute je že zaseden.',
    'uploaded' => 'Nalaganje :attribute ni uspelo.',
    'uppercase' => 'Polje :attribute mora biti z velikimi črkami.',
    'url' => 'Polje :attribute mora biti veljaven URL.',
    'ulid' => 'Polje :attribute mora biti veljaven ULID.',
    'uuid' => 'Polje :attribute mora biti veljaven UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'sporočilo po meri',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'ime',
        'username' => 'uporabniško ime',
        'email' => 'e-poštni naslov',
        'first_name' => 'ime',
        'last_name' => 'priimek',
        'password' => 'geslo',
        'password_confirmation' => 'potrditev gesla',
        'city' => 'mesto',
        'country' => 'država',
        'address' => 'naslov',
        'phone' => 'telefon',
        'mobile' => 'mobilni telefon',
        'age' => 'starost',
        'sex' => 'spol',
        'gender' => 'spol',
        'year' => 'leto',
        'month' => 'mesec',
        'day' => 'dan',
        'hour' => 'ura',
        'minute' => 'minuta',
        'second' => 'sekunda',
        'title' => 'naslov',
        'body' => 'vsebina',
        'description' => 'opis',
        'excerpt' => 'izvleček',
        'date' => 'datum',
        'time' => 'čas',
        'subject' => 'zadeva',
        'message' => 'sporočilo',
    ],

];
