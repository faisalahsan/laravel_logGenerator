<?php

namespace App\Http\Middleware;

use Closure;
use File;
use Carbon;

class TestMidLayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        //status codes with information
        $status_codes = [
            100 => 'Continue',
            101 => 'Switching protocols',
            200 => 'The client request has succeeded',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-authoritative information',
            204 => 'No content',
            205 => 'Reset content',
            206 => 'Partial content',
            302 => 'Object moved',
            304 => 'Not modified',
            307 => 'Temporary redirect',
            400 => 'Bad request',
            401 => 'Access denied',
            401.1 => 'Logon failed',
            401.2 => 'Logon failed due to server configuration',
            401.3 => 'Unauthorized due to ACL on resource',
            401.4 => 'Authorization failed by filter',
            401.5 => 'Authorization failed by ISAPI/CGI application',
            401.7 => 'Access denied by URL authorization policy on the Web server',
            403 => 'Forbidden',
            403.1 => 'Execute access forbidden',
            403.2 => 'Read access forbidden.',
            403.3 => 'Write access forbidden',
            403.4 => 'SSL required. Use HTTPS instead of HTTP to access the page',
            403.5 => 'SSL 128 required',
            403.6 => 'IP address rejected',
            403.7 => 'Client certificate required',
            403.8 => 'Site access denied',
            403.9 => 'Too many users',
            403.10 => 'Invalid configuration',
            403.11 => 'Password change',
            403.12 => 'Mapper denied access',
            403.13 => 'Client certificate revoked',
            403.14 => 'Directory listing denied',
            403.15 => 'Client Access Licenses exceeded',
            403.16 => 'Client certificate is untrusted or invalid',
            403.17 => 'Client certificate has expired or is not yet valid',
            403.18 => 'Cannot execute requested URL in the current application pool',
            403.19 => 'Cannot execute CGIs for the client in this application pool.',
            403.20 => 'Passport logon failed. This error code is specific to IIS 6.0',
            404 => 'Not found',
            404.0 => 'File or directory not found',
            404.1 => 'Web site not accessible on the requested port',
            404.2 => 'Web service extension lockdown policy prevents this request',
            404.3 => 'MIME map policy prevents this request',
            405 => 'HTTP verb used to access this page is not allowed (method not allowed)',
            406 => 'Client browser does not accept the MIME type of the requested page',
            407 => 'Proxy authentication required',
            412 => 'Precondition failed',
            413 => 'Request entity too large',
            414 => 'Request-URL too long',
            415 => 'Unsupported media type',
            416 => 'Requested range not satisfiable',
            417 => 'Execution failed',
            423 => 'Locked error',
            500 => 'Internal server error',
            500.12 => 'Application is busy restarting on the Web server',
            500.13 => 'Web server is too busy',
            500.15 => 'Direct requests for Global.asa are not allowed',
            500.16 => 'UNC authorization credentials incorrect',
            500.18 => 'URL authorization store cannot be opened',
            500.100 => 'Internal ASP error',
            501 => 'Header values specify a configuration that is not implemented',
            502 => 'Bad Gateway',
            502.1 => 'CGI application timeout',
            502.2 => 'Error in CGI application',
            503 => 'Service unavailable. This error code is specific to IIS 6.0.',
            504 => 'Gateway timeout',
            505 => 'HTTP version not supported', 
        ];

        
     	//get client ip address
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                        $ip_address = $ip;
                }
            } else {
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        
        if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ip_address = $_SERVER['HTTP_FORWARDED'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        // retrive the status information bases on status code
        $status_detail = isset($status_codes[$request->server()['REDIRECT_STATUS']]) ? $status_codes[$request->server()['REDIRECT_STATUS']] : ''; 

        // log string
        $log = 'TIME_STAMP={'.date("l jS \of F Y h:i:s A").'} STATUS_CODE={'. $request->server()['REDIRECT_STATUS'].'} STATUS_INFO={'. $status_detail .'} MEHTOD={'.$request->method().'} REQUEST_URI={'.$request->server()['CONTEXT_DOCUMENT_ROOT'].$request->server()['REQUEST_URI'].'} REDIRECT_URL={'.$request->server()['CONTEXT_DOCUMENT_ROOT'].$request->server()['REDIRECT_URL'].'} HOST={'.$request->method().'} CLIENT_IP={'. $request->getClientIp( true ) .'}'."\n";        
    
    	//write to log file
        File::append(public_path().'/mySite.log', $log );

        return $next($request);
    }
}
