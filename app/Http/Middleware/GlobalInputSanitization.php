<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalInputSanitization
{
    /**
     * Routes that should be excluded from sanitization.
     * Use route names, full URIs, or patterns with wildcards (*).
     */
    protected $excludedRoutes = [
        'resume.summary.save'
    ];

    /**
     * Fields that should be completely stripped of ALL HTML/special chars
     */
    protected $strictSanitizeFields = [
        'email',
        'first_name',
        'firstname',
        'last_name',
        'lastname',
        'name',
        'title',
        'phone',
        'mobile',
        'zip',
        'postal_code',
        'city',
        'state',
        'country',
        'username',
        'password',
        'password_confirmation',
        'card_number',
        'cvv',
        'ssn',
        'tax_id',
    ];

    /**
     * Fields that may contain safe HTML (if you need formatting)
     * Adjust based on your app's needs
     */
    protected $safeHtmlFields = [
        'bio',
        'description',
        'notes',
        'comment',
        'message',
        'content',
    ];

    /**
     * Fields that should never be sanitized (file uploads, etc.)
     */
    protected $excludeFields = [
        '_token',
        '_method',
        'desired_job_title',
        'password',
        'title',
        'description',
        'long_description',
        'meta_tags',
        'password_confirmation',
        'file',
        'files',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Skip if the route is excluded
        if ($this->shouldExcludeRoute($request)) {
            return $next($request);
        }

        // Only sanitize POST, PUT, PATCH requests
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            $input = $request->all();
            
            // Sanitize the input recursively
            $sanitizedInput = $this->sanitizeRecursively($input);
            
            // Replace the request input with sanitized version
            $request->replace($sanitizedInput);
        }
        return $next($request);
    }

    /**
     * Determine if the current route should be excluded.
     */
    protected function shouldExcludeRoute(Request $request): bool
    {
        $route = $request->route();

        // If there's no route (e.g., 404), we won't exclude
        if (!$route) {
            return false;
        }

        $routeName = $route->getName();
        $uri = $request->path(); // e.g., 'admin/users'

        foreach ($this->excludedRoutes as $pattern) {
            // Check by route name
            if ($routeName && $routeName === $pattern) {
                return true;
            }

            // Check by URI with wildcard matching
            if (Str::is($pattern, $uri)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Recursively sanitize arrays and nested data
     */
    private function sanitizeRecursively($data, $key = null)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = $this->sanitizeRecursively($v, $k);
            }
            return $data;
        }

        // Skip non-string values
        if (!is_string($data)) {
            return $data;
        }

        // Skip excluded fields
        if ($key && in_array($key, $this->excludeFields)) {
            return $data;
        }

        // Strict sanitization for sensitive/name fields
        if ($key && in_array($key, $this->strictSanitizeFields)) {
            return $this->strictSanitize($data, $key);
        }

        // Safe HTML fields (allow limited formatting)
        if ($key && in_array($key, $this->safeHtmlFields)) {
            return $this->sanitizeSafeHtml($data);
        }

        // Default: remove all HTML
        return $this->defaultSanitize($data);
    }

    /**
     * Strict sanitization for names, emails, titles
     */
    private function strictSanitize($value, $field)
    {
        // Remove all HTML tags
        $value = strip_tags($value);
        
        // Convert special characters to HTML entities
        $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Remove any JavaScript protocols
        $value = preg_replace('/javascript:/i', '', $value);
        $value = preg_replace('/vbscript:/i', '', $value);
        $value = preg_replace('/on\w+=/i', '', $value);
        
        // Field-specific cleaning
        switch ($field) {
            case 'email':
                $value = filter_var($value, FILTER_SANITIZE_EMAIL);
                $value = strtolower($value);
                break;
            case 'first_name':
            case 'last_name':
            case 'firstname':
            case 'lastname':
            case 'name':
                // Allow only letters, spaces, hyphens, dots, apostrophes
                $value = preg_replace('/[^a-zA-Z\s\-\.\']/', '', $value);
                // Limit length
                $value = substr($value, 0, 100);
                break;
            case 'title':
                // Allow letters, numbers, spaces, and basic punctuation
                $value = preg_replace('/[^a-zA-Z0-9\s\-\.\,\!\?\&\'\(\)]/', '', $value);
                $value = substr($value, 0, 200);
                break;
        }
        
        return trim($value);
    }

    /**
     * Default sanitization for unknown fields
     */
    private function defaultSanitize($value)
    {
        // Remove all HTML tags
        $value = strip_tags($value);
        
        // Convert special characters to HTML entities
        $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Remove common XSS patterns
        $value = preg_replace('/javascript:/i', 'blocked:', $value);
        $value = preg_replace('/on\w+\s*=/i', 'data-removed=', $value);
        
        return trim($value);
    }

    /**
     * Sanitize fields that may contain safe HTML
     * Adjust allowed tags based on your needs
     */
    private function sanitizeSafeHtml($value)
    {
        // Option 1: Strip all but allow specific tags
        $allowedTags = '<p><br><br/><strong><b><em><i><u><ul><ol><li><a><span><div>';
        $value = strip_tags($value, $allowedTags);
        
        // Remove dangerous attributes from allowed tags
        $value = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $value);
        $value = preg_replace('/\s+on\w+\s*=\s*[^\s>]+/i', '', $value);
        $value = preg_replace('/javascript:/i', 'blocked:', $value);
        
        // Convert special characters (but preserve HTML)
        // This is tricky - for real safe HTML, use HTML Purifier library
        // $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        return trim($value);
    }
}