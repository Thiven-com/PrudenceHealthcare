@php
    $filename = Route::currentRouteName(); // use route name instead of PHP_SELF

    $acronyms = ['ui', 'ai', 'js', 'api', 'css', 'html', 'php', 'seo', 'faq', 'rtl', 'pos'];

    if ($filename === 'index') {
        $title = 'Admin Dashboard';
    } else {
        $parts = explode('-', str_replace('ui-', '', strtolower($filename)));

        $hasIcon = false;
        $hasChart = false;
        $cleaned_parts = [];

        foreach ($parts as $part) {
            if ($part === 'icon') {
                $hasIcon = true;
                continue;
            }
            if ($part === 'chart') {
                $hasChart = true;
                continue;
            }
            if ($part === 'all') {
                continue;
            }
            $cleaned_parts[] = $part;
        }

        $formatted_parts = array_map(function ($word) use ($acronyms) {
            return in_array($word, $acronyms) ? strtoupper($word) : ucfirst($word);
        }, $cleaned_parts);

        if ($hasIcon) {
            $formatted_parts[] = 'Icons';
        }
        if ($hasChart) {
            $formatted_parts[] = 'Charts';
        }

        $title = implode(' ', $formatted_parts);
    }
@endphp

<!-- Meta Tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Prudence Health Care provides trusted healthcare services, quality medical care, and patient-focused solutions to promote better health and well-being.">
<meta name="keywords" content="Prudence Health Care, healthcare services, medical care, hospital, patient care, healthcare solutions, medical services, health and wellness">
<meta name="author" content="Prudence Health Care">
<meta name="robots" content="index, follow">
<title>{{ $title }} | Prudence Health Care - Quality Healthcare Services</title>
