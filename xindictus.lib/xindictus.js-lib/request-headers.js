/**
 * Created by Xindictus on 17/12/2016.
 */
$.ajaxSetup({
    headers: {
        'Cache-Control': 'no-cache, no-store, must-revalidate',
        'Pragma': 'no-cache',
        'Expires': '0',
        'Strict-Transport-Security': 'max-age=31536000 ; includeSubDomains',
        'X-Frame-Options': 'SAMEORIGIN',
        'X-XSS-Protection': '1; mode=block',
        'X-Content-Type-Options': 'nosniff',
        'X-Permitted-Cross-Domain-Policies': 'none'
    }
});