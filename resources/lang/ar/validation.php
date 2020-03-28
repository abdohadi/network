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

    'accepted'        => 'ﻳﺠﺐ ﻗﺒﻮﻝ :attribute.',
    'active_url'      => ':attribute ﻻ ﻳُﻤﺜّﻞ ﺭاﺑﻄًﺎ ﺻﺤﻴﺤًﺎ.',
    'after'           => 'ﻳﺠﺐ ﻋﻠﻰ :attribute ﺃﻥ ﻳﻜﻮﻥ ﺗﺎﺭﻳﺨًﺎ ﻻﺣﻘًﺎ ﻟﻠﺘﺎﺭﻳﺦ :date.',
    'after_or_equal'  => ':attribute ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺗﺎﺭﻳﺨﺎً ﻻﺣﻘﺎً ﺃﻭ ﻣﻄﺎﺑﻘﺎً ﻟﻠﺘﺎﺭﻳﺦ :date.',
    'alpha'           => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺤﺘﻮﻱ :attribute ﺳﻮﻯ ﻋﻠﻰ ﺣﺮﻭﻑ.',
    'alpha_dash'      => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺤﺘﻮﻱ :attribute ﺳﻮﻯ ﻋﻠﻰ ﺣﺮﻭﻑ، ﺃﺭﻗﺎﻡ ﻭﻣﻄّﺎﺕ.',
    'alpha_num'       => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ ﺣﺮﻭﻑٍ ﻭﺃﺭﻗﺎﻡٍ ﻓﻘﻂ.',
    'array'           => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ًﻣﺼﻔﻮﻓﺔ.',
    'before'          => 'ﻳﺠﺐ ﻋﻠﻰ :attribute ﺃﻥ ﻳﻜﻮﻥ ﺗﺎﺭﻳﺨًﺎ ﺳﺎﺑﻘًﺎ ﻟﻠﺘﺎﺭﻳﺦ :date.',
    'before_or_equal' => ':attribute ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺗﺎﺭﻳﺨﺎ ﺳﺎﺑﻘﺎ ﺃﻭ ﻣﻄﺎﺑﻘﺎ ﻟﻠﺘﺎﺭﻳﺦ :date.',
    'between'         => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﺑﻴﻦ :min ﻭ :max.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute ﺑﻴﻦ :min ﻭ :max ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻋﺪﺩ ﺣﺮﻭﻑ اﻟﻨّﺺ :attribute ﺑﻴﻦ :min ﻭ :max.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ ﻋﺪﺩ ﻣﻦ اﻟﻌﻨﺎﺻﺮ ﺑﻴﻦ :min ﻭ :max.',
    ],
    'boolean'        => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﺇﻣﺎ true ﺃﻭ false .',
    'confirmed'      => 'ﺣﻘﻞ اﻟﺘﺄﻛﻴﺪ ﻏﻴﺮ ﻣُﻄﺎﺑﻖ ﻟﻠﺤﻘﻞ :attribute.',
    'date'           => ':attribute ﻟﻴﺲ ﺗﺎﺭﻳﺨًﺎ ﺻﺤﻴﺤًﺎ.',
    'date_equals'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻣﻄﺎﺑﻘﺎً ﻟﻠﺘﺎﺭﻳﺦ :date.',
    'date_format'    => 'ﻻ ﻳﺘﻮاﻓﻖ :attribute ﻣﻊ اﻟﺸﻜﻞ :format.',
    'different'      => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ اﻟﺤﻘﻼﻥ :attribute ﻭ :other ﻣُﺨﺘﻠﻔﻴﻦ.',
    'digits'         => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ :digits ﺭﻗﻤًﺎ/ﺃﺭﻗﺎﻡ.',
    'digits_between' => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﺑﻴﻦ :min ﻭ :max ﺭﻗﻤًﺎ/ﺃﺭﻗﺎﻡ .',
    'dimensions'     => 'اﻝـ :attribute ﻳﺤﺘﻮﻱ ﻋﻠﻰ ﺃﺑﻌﺎﺩ ﺻﻮﺭﺓ ﻏﻴﺮ ﺻﺎﻟﺤﺔ.',
    'distinct'       => 'ﻟﻠﺤﻘﻞ :attribute ﻗﻴﻤﺔ ﻣُﻜﺮّﺭﺓ.',
    'email'          => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻋﻨﻮاﻥ ﺑﺮﻳﺪ ﺇﻟﻜﺘﺮﻭﻧﻲ ﺻﺤﻴﺢ اﻟﺒُﻨﻴﺔ.',
    'ends_with'      => 'ﻳﺠﺐ ﺃﻥ ﻳﻨﺘﻬﻲ :attribute ﺑﺄﺣﺪ اﻟﻘﻴﻢ اﻟﺘﺎﻟﻴﺔ: :values',
    'exists'         => 'اﻟﻘﻴﻤﺔ اﻟﻤﺤﺪﺩﺓ :attribute ﻏﻴﺮ ﻣﻮﺟﻮﺩﺓ.',
    'file'           => 'اﻝـ :attribute ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻣﻠﻔﺎ.',
    'filled'         => ':attribute ﺇﺟﺒﺎﺭﻱ.',
    'gt'             => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﺃﻛﺒﺮ ﻣﻦ :value.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute ﺃﻛﺒﺮ ﻣﻦ :value ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻃﻮﻝ اﻟﻨّﺺ :attribute ﺃﻛﺜﺮ ﻣﻦ :value ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ ﺃﻛﺜﺮ ﻣﻦ :value ﻋﻨﺎﺻﺮ/ﻋﻨﺼﺮ.',
    ],
    'gte' => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﻣﺴﺎﻭﻳﺔ ﺃﻭ ﺃﻛﺒﺮ ﻣﻦ :value.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute ﻋﻠﻰ اﻷﻗﻞ :value ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻃﻮﻝ اﻟﻨﺺ :attribute ﻋﻠﻰ اﻷﻗﻞ :value ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ اﻷﻗﻞ ﻋﻠﻰ :value ﻋُﻨﺼﺮًا/ﻋﻨﺎﺻﺮ.',
    ],
    'image'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ًﺻﻮﺭﺓ.',
    'in'       => ':attribute ﻏﻴﺮ ﻣﻮﺟﻮﺩ.',
    'in_array' => ':attribute ﻏﻴﺮ ﻣﻮﺟﻮﺩ ﻓﻲ :other.',
    'integer'  => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻋﺪﺩًا ﺻﺤﻴﺤًﺎ.',
    'ip'       => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻋﻨﻮاﻥ IP ﺻﺤﻴﺤًﺎ.',
    'ipv4'     => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻋﻨﻮاﻥ IPv4 ﺻﺤﻴﺤًﺎ.',
    'ipv6'     => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻋﻨﻮاﻥ IPv6 ﺻﺤﻴﺤًﺎ.',
    'json'     => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻧﺼﺂ ﻣﻦ ﻧﻮﻉ JSON.',
    'lt'       => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﺃﺻﻐﺮ ﻣﻦ :value.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute ﺃﺻﻐﺮ ﻣﻦ :value ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻃﻮﻝ اﻟﻨّﺺ :attribute ﺃﻗﻞ ﻣﻦ :value ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ ﺃﻗﻞ ﻣﻦ :value ﻋﻨﺎﺻﺮ/ﻋﻨﺼﺮ.',
    ],
    'lte' => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﻣﺴﺎﻭﻳﺔ ﺃﻭ ﺃﺻﻐﺮ ﻣﻦ :value.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺘﺠﺎﻭﺯ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute :value ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺘﺠﺎﻭﺯ ﻃﻮﻝ اﻟﻨّﺺ :attribute :value ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ ﺃﻛﺜﺮ ﻣﻦ :value ﻋﻨﺎﺻﺮ/ﻋﻨﺼﺮ.',
    ],
    'max' => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﻣﺴﺎﻭﻳﺔ ﺃﻭ ﺃﺻﻐﺮ ﻣﻦ :max.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺘﺠﺎﻭﺯ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute :max ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺘﺠﺎﻭﺯ ﻃﻮﻝ اﻟﻨّﺺ :attribute :max ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻻ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ ﺃﻛﺜﺮ ﻣﻦ :max ﻋﻨﺎﺻﺮ/ﻋﻨﺼﺮ.',
    ],
    'mimes'     => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻣﻠﻔًﺎ ﻣﻦ ﻧﻮﻉ : :values.',
    'mimetypes' => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻣﻠﻔًﺎ ﻣﻦ ﻧﻮﻉ : :values.',
    'min'       => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﻣﺴﺎﻭﻳﺔ ﺃﻭ ﺃﻛﺒﺮ ﻣﻦ :min.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute ﻋﻠﻰ اﻷﻗﻞ :min ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﻃﻮﻝ اﻟﻨﺺ :attribute ﻋﻠﻰ اﻷﻗﻞ :min ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ اﻷﻗﻞ ﻋﻠﻰ :min ﻋُﻨﺼﺮًا/ﻋﻨﺎﺻﺮ.',
    ],
    'not_in'               => 'اﻟﻌﻨﺼﺮ :attribute ﻏﻴﺮ ﺻﺤﻴﺢ.',
    'not_regex'            => 'ﺻﻴﻐﺔ :attribute ﻏﻴﺮ ﺻﺤﻴﺤﺔ.',
    'numeric'              => 'ﻳﺠﺐ ﻋﻠﻰ :attribute ﺃﻥ ﻳﻜﻮﻥ ﺭﻗﻤًﺎ.',
    'password'             => 'ﻛﻠﻤﺔ اﻟﻤﺮﻭﺭ ﻏﻴﺮ ﺻﺤﻴﺤﺔ.',
    'present'              => 'ﻳﺠﺐ ﺗﻘﺪﻳﻢ :attribute.',
    'regex'                => 'ﺻﻴﻐﺔ :attribute .ﻏﻴﺮ ﺻﺤﻴﺤﺔ.',
    'required'             => ':attribute ﻣﻄﻠﻮﺏ.',
    'required_if'          => ':attribute ﻣﻄﻠﻮﺏ ﻓﻲ ﺣﺎﻝ ﻣﺎ ﺇﺫا ﻛﺎﻥ :other ﻳﺴﺎﻭﻱ :value.',
    'required_unless'      => ':attribute ﻣﻄﻠﻮﺏ ﻓﻲ ﺣﺎﻝ ﻣﺎ ﻟﻢ ﻳﻜﻦ :other ﻳﺴﺎﻭﻱ :values.',
    'required_with'        => ':attribute ﻣﻄﻠﻮﺏ ﺇﺫا ﺗﻮﻓّﺮ :values.',
    'required_with_all'    => ':attribute ﻣﻄﻠﻮﺏ ﺇﺫا ﺗﻮﻓّﺮ :values.',
    'required_without'     => ':attribute ﻣﻄﻠﻮﺏ ﺇﺫا ﻟﻢ ﻳﺘﻮﻓّﺮ :values.',
    'required_without_all' => ':attribute ﻣﻄﻠﻮﺏ ﺇﺫا ﻟﻢ ﻳﺘﻮﻓّﺮ :values.',
    'same'                 => 'ﻳﺠﺐ ﺃﻥ ﻳﺘﻄﺎﺑﻖ :attribute ﻣﻊ :other.',
    'size'                 => [
        'numeric' => 'ﻳﺠﺐ ﺃﻥ ﺗﻜﻮﻥ ﻗﻴﻤﺔ :attribute ﻣﺴﺎﻭﻳﺔ ﻝـ :size.',
        'file'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺣﺠﻢ اﻟﻤﻠﻒ :attribute :size ﻛﻴﻠﻮﺑﺎﻳﺖ.',
        'string'  => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ اﻟﻨﺺ :attribute ﻋﻠﻰ :size ﺣﺮﻭﻑٍ/ﺣﺮﻓًﺎ ﺑﺎﻟﻀﺒﻂ.',
        'array'   => 'ﻳﺠﺐ ﺃﻥ ﻳﺤﺘﻮﻱ :attribute ﻋﻠﻰ :size ﻋﻨﺼﺮٍ/ﻋﻨﺎﺻﺮ ﺑﺎﻟﻀﺒﻂ.',
    ],
    'starts_with' => 'ﻳﺠﺐ ﺃﻥ ﻳﺒﺪﺃ :attribute ﺑﺄﺣﺪ اﻟﻘﻴﻢ اﻟﺘﺎﻟﻴﺔ: :values',
    'string'      => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻧﺼًﺎ.',
    'timezone'    => 'ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ :attribute ﻧﻄﺎﻗًﺎ ﺯﻣﻨﻴًﺎ ﺻﺤﻴﺤًﺎ.',
    'unique'      => 'ﻗﻴﻤﺔ :attribute ﻣُﺴﺘﺨﺪﻣﺔ ﻣﻦ ﻗﺒﻞ.',
    'uploaded'    => 'ﻓﺸﻞ ﻓﻲ ﺗﺤﻤﻴﻞ اﻝـ :attribute.',
    'url'         => 'ﺻﻴﻐﺔ اﻟﺮاﺑﻂ :attribute ﻏﻴﺮ ﺻﺤﻴﺤﺔ.',
    'uuid'        => ':attribute ﻳﺠﺐ ﺃﻥ ﻳﻜﻮﻥ ﺑﺼﻴﻐﺔ UUID ﺳﻠﻴﻤﺔ.',

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

    'attributes' => [
        'name'                  => 'اﻻﺳﻢ',
        'username'              => 'اﺳﻢ اﻟﻤُﺴﺘﺨﺪﻡ',
        'email'                 => 'اﻟﺒﺮﻳﺪ اﻻﻟﻜﺘﺮﻭﻧﻲ',
        'first_name'            => 'اﻻﺳﻢ اﻷﻭﻝ',
        'last_name'             => 'اﺳﻢ اﻟﻌﺎﺋﻠﺔ',
        'password'              => 'ﻛﻠﻤﺔ اﻟﻤﺮﻭﺭ',
        'password_confirmation' => 'ﺗﺄﻛﻴﺪ ﻛﻠﻤﺔ اﻟﻤﺮﻭﺭ',
        'city'                  => 'اﻟﻤﺪﻳﻨﺔ',
        'country'               => 'اﻟﺪﻭﻟﺔ',
        'address'               => 'ﻋﻨﻮاﻥ اﻟﺴﻜﻦ',
        'phone'                 => 'اﻟﻬﺎﺗﻒ',
        'mobile'                => 'اﻟﺠﻮاﻝ',
        'age'                   => 'اﻟﻌﻤﺮ',
        'sex'                   => 'اﻟﺠﻨﺲ',
        'gender'                => 'اﻟﻨﻮﻉ',
        'day'                   => 'اﻟﻴﻮﻡ',
        'month'                 => 'اﻟﺸﻬﺮ',
        'year'                  => 'اﻟﺴﻨﺔ',
        'hour'                  => 'ﺳﺎﻋﺔ',
        'minute'                => 'ﺩﻗﻴﻘﺔ',
        'second'                => 'ﺛﺎﻧﻴﺔ',
        'title'                 => 'اﻟﻌﻨﻮاﻥ',
        'content'               => 'اﻟﻤُﺤﺘﻮﻯ',
        'description'           => 'اﻟﻮﺻﻒ',
        'excerpt'               => 'اﻟﻤُﻠﺨﺺ',
        'date'                  => 'اﻟﺘﺎﺭﻳﺦ',
        'time'                  => 'اﻟﻮﻗﺖ',
        'available'             => 'ﻣُﺘﺎﺡ',
        'size'                  => 'اﻟﺤﺠﻢ',
        'body'                  => 'اﻟﺤﻘﻞ',
        'birth_date'            => 'تاريخ الميلاد',
        'college'               => 'الكليه / المدرسه',
        'bio'                   => 'نبذه مختصره'

    ],
];
