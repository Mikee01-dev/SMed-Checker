<?php

if (!function_exists('getLogo')) {
    function getLogo($size = 'md')
    {
        $logoPath = public_path('images/logo.png');
        
        if (file_exists($logoPath)) {
            $sizes = [
                'sm' => 'w-6 h-6',
                'md' => 'w-8 h-8', 
                'lg' => 'w-12 h-12',
                'xl' => 'w-20 h-20',
            ];
            
            $class = $sizes[$size] ?? $sizes['md'];
            
            return '<img src="' . asset('images/logo.png') . '" alt="SMed Checker" class="' . $class . '">';
        }
        
        return '<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg ' . ($size == 'xl' ? 'w-20 h-20' : 'w-8 h-8') . ' flex items-center justify-center">
                    <i class="fa-regular fa-message text-white text-sm"></i>
                </div>';
    }
}

if (!function_exists('getLogoBase64')) {
    function getLogoBase64()
    {
        $logoPath = public_path('images/logo.png');
        
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        
        return null;
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon()
    {
        $faviconPath = public_path('favicon.ico');
        $faviconPngPath = public_path('favicon.png');
        
        if (file_exists($faviconPath)) {
            return '<link rel="icon" type="image/x-icon" href="' . asset('favicon.ico') . '">';
        }
        
        if (file_exists($faviconPngPath)) {
            return '<link rel="icon" type="image/png" href="' . asset('favicon.png') . '">';
        }
        
        return '';
    }
}