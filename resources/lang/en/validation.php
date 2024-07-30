<?php

return [
    'custom' => [
        'pages.*.doc_page_name.required'                     => 'The page name is required.',
        'pages.*.doc_page_description.required'              => 'The page description is required.',
        'pages.*.groups.*.pg_name.required'                  => 'The group name is required.',
        'pages.*.groups.*.variables.*.pv_name.required'      => 'The variable name is required.',
        'pages.*.groups.*.variables.*.pv_question.required'  => 'The variable question is required.',
        'pages.*.groups.*.variables.*.pv_type.required'      => 'The variable type is required.',
        'pages.*.groups.*.variables.*.pv_type.numeric'       => 'The variable type must be a number.',
        'pages.*.groups.*.variables.*.pv_required.required'  => 'The variable required field is required.',
        'pages.*.groups.*.variables.*.pv_required.boolean'   => 'The variable required field must be true or false.',
        'pages.*.groups.*.variables.*.pv_details.required'   => 'The variable details are required.',
    ],

    "accepted" => "The :attribute must be accepted.",
    "accepted_if" => "The :attribute must be accepted when :other is :value.",
    "active_url" => "The :attribute is not a valid URL.",
    "after" => "The :attribute must be a date after :date.",
    "after_or_equal" => "The :attribute must be a date after or equal to :date.",
    "alpha" => "The :attribute must only contain letters.",
    "alpha_dash" => "The :attribute must only contain letters, numbers, dashes and underscores.",
    "alpha_num" => "The :attribute must only contain letters and numbers.",
    "array" => "The :attribute must be an array.",
    "ascii" => "The :attribute field must only contain single-byte alphanumeric characters and symbols.",
    "attached" => "This :attribute is already attached.",
    "before" => "The :attribute must be a date before :date.",
    "before_or_equal" => "The :attribute must be a date before or equal to :date.",
    "between.array" => "The :attribute must have between :min and :max items.",
    "between.file" => "The :attribute must be between :min and :max kilobytes.",
    "between.numeric" => "The :attribute must be between :min and :max.",
    "between.string" => "The :attribute must be between :min and :max characters.",
    "boolean" => "The :attribute field must be true or false.",
    "can" => "The :attribute field contains an unauthorized value.",
    "confirmed" => "The :attribute confirmation does not match.",
    "current_password" => "The password is incorrect.",
    "date" => "The :attribute is not a valid date.",
    "date_equals" => "The :attribute must be a date equal to :date.",
    "date_format" => "The :attribute does not match the format :format.",
    "decimal" => "The :attribute field must have :decimal decimal places.",
    "declined" => "The :attribute must be declined.",
    "declined_if" => "The :attribute must be declined when :other is :value.",
    "different" => "The :attribute and :other must be different.",
    "digits" => "The :attribute must be :digits digits.",
    "digits_between" => "The :attribute must be between :min and :max digits.",
    "dimensions" => "The :attribute has invalid image dimensions.",
    "distinct" => "The :attribute field has a duplicate value.",
    "doesnt_end_with" => "The :attribute field must not end with one of the following: :values.",
    "doesnt_start_with" => "The :attribute field must not start with one of the following: :values.",
    "email" => "The :attribute must be a valid email address.",
    "ends_with" => "The :attribute must end with one of the following: :values.",
    "enum" => "The selected :attribute is invalid.",
    "exists" => "The selected :attribute is invalid.",
    "extensions" => "The :attribute field must have one of the following extensions: :values.",
    "failed" => "These credentials do not match our records.",
    "file" => "The :attribute must be a file.",
    "filled" => "The :attribute field must have a value.",
    "gt.array" => "The :attribute must have more than :value items.",
    "gt.file" => "The :attribute must be greater than :value kilobytes.",
    "gt.numeric" => "The :attribute must be greater than :value.",
    "gt.string" => "The :attribute must be greater than :value characters.",
    "gte.array" => "The :attribute must have :value items or more.",
    "gte.file" => "The :attribute must be greater than or equal to :value kilobytes.",
    "gte.numeric" => "The :attribute must be greater than or equal to :value.",
    "gte.string" => "The :attribute must be greater than or equal to :value characters.",
    "hex_color" => "The :attribute field must be a valid hexadecimal color.",
    "image" => "The :attribute must be an image.",
    "in" => "The selected :attribute is invalid.",
    "in_array" => "The :attribute field does not exist in :other.",
    "integer" => "The :attribute must be an integer.",
    "ip" => "The :attribute must be a valid IP address.",
    "ipv4" => "The :attribute must be a valid IPv4 address.",
    "ipv6" => "The :attribute must be a valid IPv6 address.",
    "json" => "The :attribute must be a valid JSON string.",
    "lowercase" => "The :attribute field must be lowercase.",
    "lt.array" => "The :attribute must have less than :value items.",
    "lt.file" => "The :attribute must be less than :value kilobytes.",
    "lt.numeric" => "The :attribute must be less than :value.",
    "lt.string" => "The :attribute must be less than :value characters.",
    "lte.array" => "The :attribute must not have more than :value items.",
    "lte.file" => "The :attribute must be less than or equal to :value kilobytes.",
    "lte.numeric" => "The :attribute must be less than or equal to :value.",
    "lte.string" => "The :attribute must be less than or equal to :value characters.",
    "mac_address" => "The :attribute must be a valid MAC address.",
    "max.array" => "The :attribute must not have more than :max items.",
    "max.file" => "The :attribute must not be greater than :max kilobytes.",
    "max.numeric" => "The :attribute must not be greater than :max.",
    "max.string" => "The :attribute must not be greater than :max characters.",
    "max_digits" => "The :attribute field must not have more than :max digits.",
    "mimes" => "The :attribute must be a file of type: :values.",
    "mimetypes" => "The :attribute must be a file of type: :values.",
    "min.array" => "The :attribute must have at least :min items.",
    "min.file" => "The :attribute must be at least :min kilobytes.",
    "min.numeric" => "The :attribute must be at least :min.",
    "min.string" => "The :attribute must be at least :min characters.",
    "min_digits" => "The :attribute field must have at least :min digits.",
    "missing" => "The :attribute field must be missing.",
    "missing_if" => "The :attribute field must be missing when :other is :value.",
    "missing_unless" => "The :attribute field must be missing unless :other is :value.",
    "missing_with" => "The :attribute field must be missing when :values is present.",
    "missing_with_all" => "The :attribute field must be missing when :values are present.",
    "multiple_of" => "The :attribute must be a multiple of :value.",
    "next" => "Next &raquo;",
    "not_in" => "The selected :attribute is invalid.",
    "not_regex" => "The :attribute format is invalid.",
    "numeric" => "The :attribute must be a number.",
    "password" => "The password is incorrect.",
    "password.letters" => "The :attribute field must contain at least one letter.",
    "password.mixed" => "The :attribute field must contain at least one uppercase and one lowercase letter.",
    "password.numbers" => "The :attribute field must contain at least one number.",
    "password.symbols" => "The :attribute field must contain at least one symbol.",
    "password.uncompromised" => "The given :attribute has appeared in a data leak. Please choose a different :attribute.",
    "present" => "The :attribute field must be present.",
    "present_if" => "The :attribute field must be present when :other is :value.",
    "present_unless" => "The :attribute field must be present unless :other is :value.",
    "present_with" => "The :attribute field must be present when :values is present.",
    "present_with_all" => "The :attribute field must be present when :values are present.",
    "previous" => "&laquo; Previous",
    "prohibited" => "The :attribute field is prohibited.",
    "prohibited_if" => "The :attribute field is prohibited when :other is :value.",
    "prohibited_unless" => "The :attribute field is prohibited unless :other is in :values.",
    "prohibits" => "The :attribute field prohibits :other from being present.",
    "regex" => "The :attribute format is invalid.",
    "relatable" => "This :attribute may not be associated with this resource.",
    "required" => "The :attribute field is required.",
    "required_array_keys" => "The :attribute field must contain entries for: :values.",
    "required_if" => "The :attribute field is required when :other is :value.",
    "required_if_accepted" => "The :attribute field is required when :other is accepted.",
    "required_unless" => "The :attribute field is required unless :other is in :values.",
    "required_with" => "The :attribute field is required when :values is present.",
    "required_with_all" => "The :attribute field is required when :values are present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "reset" => "Your password has been reset.",
    "same" => "The :attribute and :other must match.",
    "sent" => "We have emailed your password reset link.",
    "size.array" => "The :attribute must contain :size items.",
    "size.file" => "The :attribute must be :size kilobytes.",
    "size.numeric" => "The :attribute must be :size.",
    "size.string" => "The :attribute must be :size characters.",
    "starts_with" => "The :attribute must start with one of the following: :values.",
    "string" => "The :attribute must be a string.",
    "throttle" => "Too many login attempts. Please try again in :seconds seconds.",
    "throttled" => "Please wait before retrying.",
    "timezone" => "The :attribute must be a valid timezone.",
    "token" => "This password reset token is invalid.",
    "ulid" => "The :attribute field must be a valid ULID.",
    "unique" => "The :attribute has already been taken.",
    "uploaded" => "The :attribute failed to upload.",
    "uppercase" => "The :attribute field must be uppercase.",
    "url" => "The :attribute must be a valid URL.",
    "user" => "We can't find a user with that email address.",
    "uuid" => "The :attribute must be a valid UUID.",

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

    'min_words' => 'The :attribute must contain at least :min_words words.',

];
