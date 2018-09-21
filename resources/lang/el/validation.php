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

    'accepted'             => 'Το πεδίο :attribute πρέπει να γίνει αποδεκτό.',
    'active_url'           => 'Το πεδίο :attribute δεν είναι έγκυρη διεύθυνση URL.',
    'after'                => 'Το πεδίο :attribute πρέπει να είναι μια ημερομηνία μετά της :date.',
    'after_or_equal'       => 'Το πεδίο :attribute πρέπει να είναι ημερομηνία μετά ή ίση με :date.',
    'alpha'                => 'Το πεδίο :attribute μπορεί να περιέχει μόνο γράμματα.',
    'alpha_dash'           => 'Το πεδίο :attribute μπορεί να περιέχει μόνο γράμματα, αριθμούς και παύλες.',
    'alpha_num'            => 'Το πεδίο :attribute μπορεί να περιέχει μόνο γράμματα και αριθμούς.',
    'array'                => 'Το πεδίο :attribute πρέπει να είναι ένας πίνακας.',
    'before'               => 'Το πεδίο :attribute πρέπει να είναι μια ημερομηνία πριν από :date.',
    'before_or_equal'      => 'Το πεδίο :attribute πρέπει να είναι ημερομηνία πριν ή ίση με :date.',
    'between'              => [
        'numeric' => 'Το πεδίο :attribute πρέπει να είναι μεταξύ :min και :max.',
        'file'    => 'Το πεδίο :attribute πρέπει να είναι μεταξύ :min και :max kilobytes.',
        'string'  => 'Το πεδίο :attribute πρέπει να είναι μεταξύ :min και :max characters.',
        'array'   => 'Το πεδίο :attribute πρέπει να είναι μεταξύ :min και :max items.',
    ],
    'boolean'              => 'Το πεδίο :attribute Το πεδίο πρέπει να είναι αληθές ή ψευδές.',
    'confirmed'            => 'Στο πεδίο :attribute η επιβεβαίωση δεν ταιριάζει.',
    'date'                 => 'Το πεδίο :attribute δεν είναι έγκυρη ημερομηνία.',
    'date_format'          => 'Το πεδίο :attribute δε ταιριάζει στη μορφή :format.',
    'different'            => 'Το πεδίο :attribute και :other πρέπει να είναι διαφορετικά.',
    'digits'               => 'Το πεδίο :attribute πρέπει να είναι :digits ψηφία.',
    'digits_between'       => 'Το πεδίο :attribute πρέπει να είναι μεταξύ :min και :max digits.',
    'dimensions'           => 'Το πεδίο :attribute δεν έχει έγκυρες διαστάσεις εικόνας.',
    'distinct'             => 'Το πεδίο :attribute πεδίο έχει διπλή τιμή.',
    'email'                => 'Το πεδίο :attribute πρέπει να είναι έγκυρη διεύθυνση ηλεκτρονικού ταχυδρομείου.',
    'exists'               => 'Το επιλεγμένο πεδίο :attribute δεν είναι έγκυρο.',
    'file'                 => 'Το :attribute πρέπει να είναι αρχείο.',
    'filled'               => 'Το :attribute πεδίο πρέπει να έχει τιμή.',
    'image'                => 'Το πεδίο :attribute πρέπει να είναι εικόνα.',
    'in'                   => 'Το πεδίο :attribute δεν είναι έγκυρο.',
    'in_array'             => 'Το πεδίο :attribute δεν υπάρχει στο :other.',
    'integer'              => 'Το πεδίο :attribute πρέπει να είναι ακέραιος.',
    'ip'                   => 'Το πεδίο :attribute πρέπει να είναι έγκυρη διεύθυνση IP.',
    'ipv4'                 => 'Το πεδίο :attribute πρέπει να είναι έγκυρη διεύθυνση IPv4.',
    'ipv6'                 => 'Το πεδίο :attribute πρέπει να είναι έγκυρη διεύθυνση IPv6.',
    'json'                 => 'Το πεδίο :attribute πρέπει να είναι έγκυρο JSON string.',
    'max'                  => [
        'numeric' => 'Το πεδίο :attribute δε μπορεί να είναι μεγαλύτερο από :max.',
        'file'    => 'Το πεδίο :attribute δε μπορεί να είναι μεγαλύτερο από :max kilobytes.',
        'string'  => 'Το πεδίο :attribute δε μπορεί να είναι μεγαλύτερο από :max χαρακτήρες.',
        'array'   => 'Το πεδίο :attribute πρέπει να έχει έως :max αντικείμενα.',
    ],
    'mimes'                => 'Το πεδίο :attribute πρέπει να είναι αρχείο τύπου: :values.',
    'mimetypes'            => 'Το πεδίο :attribute πρέπει να είναι αρχείο τύπου: :values.',
    'min'                  => [
        'numeric' => 'Το πεδίο :attribute πρέπει να είναι τουλάχιστον :min.',
        'file'    => 'Το πεδίο :attribute πρέπει να είναι τουλάχιστον :min kilobytes.',
        'string'  => 'Το πεδίο :attribute πρέπει να είναι τουλάχιστον :min χαρακτήρες.',
        'array'   => 'Το πεδίο :attribute πρέπει να έχει τουλάχιστον :min αντικείμενα.',
    ],
    'not_in'               => 'Το πεδίο :attribute δεν είναι έγκυρο.',
    'numeric'              => 'Το πεδίο :attribute πρέπει να είναι αριθμούς.',
    'present'              => 'Το πεδίο :attribute πεδίο πρέπει να υπάρχει.',
    'regex'                => 'Το πεδίο :attribute δεν είναι έγκυρο.',
    'required'             => 'Το πεδίο :attribute είναι υποχρεωτικό.',
    'required_if'          => 'Το πεδίο :attribute είναι υποχρεωτικό όταν :other είναι :value.',
    'required_unless'      => 'Το πεδίο :attribute είναι υποχρεωτικό εκτός :other είναι σε :values.',
    'required_with'        => 'Το πεδίο :attribute είναι υποχρεωτικό όταν :values υπάρχει.',
    'required_with_all'    => 'Το πεδίο :attribute είναι υποχρεωτικό όταν :values υπάρχουν.',
    'required_without'     => 'Το πεδίο :attribute είναι υποχρεωτικό όταν :values δεν υπάρχουν.',
    'required_without_all' => 'Το πεδίο :attribute είναι υποχρεωτικό όταν δεν υπάρχουν οι τιμές :values.',
    'same'                 => 'Το πεδίο :attribute και :other πρέπει να ταιριάζουν.',
    'size'                 => [
        'numeric' => 'Το πεδίο :attribute πρέπει να είναι :size.',
        'file'    => 'Το πεδίο :attribute πρέπει να είναι :size kilobytes.',
        'string'  => 'Το πεδίο :attribute πρέπει να είναι :size characters.',
        'array'   => 'Το πεδίο :attribute πρέπει να περιέχει :size αντικείμενα.',
    ],
    'string'               => 'Το πεδίο :attribute πρέπει να είναι σειρά χαρακτήρων.',
    'timezone'             => 'Το πεδίο :attribute πρέπει να είναι έγκυρη ζώνη ώρας.',
    'unique'               => 'Το στοιχείο :attribute χρησιμοποιείται ήδη.',
    'uploaded'             => 'Το πεδίο :attribute δε μπόρεσε να ανεβεί.',
    'url'                  => 'Η μορφή του πεδίου :attribute δεν είναι έγκυρη.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
