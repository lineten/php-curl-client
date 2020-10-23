<?php

namespace Lineten\CurlClient\Constant;

class HttpRequestHeader 
{
    // Standard request header fields
    const A_IM = 'A-IM';
    const ACCEPT = 'Accept';
    const ACCEPT_CHARSET = 'Accept-Charset';
    const ACCEPT_DATETIME = 'Accept-Datetime';
    const ACCEPT_ENCODING = 'Accept-Encoding';
    const ACCEPT_LANGUAGE = 'Accept-Language';
    const ACCESS_CONTROL_REQUEST_METHOD = 'Access-Control-Request-Method';
    const ACCESS_CONTROL_REQUEST_HEADERS = 'Access-Control-Request-Headers';
    const AUTHORIZATION = 'Authorization';
    const CACHE_CONTROL = 'Cache-Control';
    const CONNECTION = 'Connection';
    const CONTENT_ENCODING = 'Content-Encoding';
    const CONTENT_LENGTH = 'Content-Length';
    const CONTENT_MD5 = 'Content-MD5';
    const CONTENT_TYPE = 'Content-Type';
    const COOKIE = 'Cookie';
    const DATE = 'Date';
    const EXPECT = 'Expect';
    const FORWARDED = 'Forwarded';
    const FROM = 'From';
    const HOST = 'Host';
    const HTTP2_SETTINGS = 'HTTP2-Settings';
    const IF_MATCH = 'If-Match';
    const IF_MODIFIED_SINCE = 'If-Modified-Since';
    const IF_NONE_MATCH = 'If-None-Match';
    const IF_RANGE = 'If-Range';
    const IF_UNMODIFIED_SINCE = 'If-Unmodified-Since';
    const MAX_FORWARDS = 'Max-Forwards';
    const ORIGIN = 'Origin';
    const PRAGMA = 'Pragma';
    const PROXY_AUTHORIZATION = 'Proxy-Authorization';
    const RANGE = 'Range';
    const REFERER = 'Referer';
    const TE = 'TE';
    const TRAILER = 'Trailer';
    const TRANSFER_ENCODING = 'Transfer-Encoding';
    const USER_AGENT = 'User-Agent';
    const UPGRADE = 'Upgrade';
    const VIA = 'Via';
    const WARNING = 'Warning';

    // Non standard request header fields
    const UPGRADE_INSECURE_REQUESTS = 'Upgrade-Insecure-Requests';
    const DNT = 'DNT';
    const X_REQUESTED_WITH = 'X-Requested-With';
    const X_FORWARDED_FOR = 'X-Forwarded-For';
    const X_FORWARDED_HOST ='X-Forwarded-Host';
    const X_FORWARDED_PROTO = 'X-Forwarded-Proto';
    const FRONT_END_HTTPS = 'Front-End-Https';
    const X_HTTP_METHOD_OVERRIDE = 'X-Http-Method-Override';
    const X_ATT_DEVICE_ID = 'X-ATT-DeviceId';
    const X_WAP_PROFILE = 'X-Wap-Profile';
    const PROXY_CONNECTION = 'Proxy-Connection';
    const X_UIDH = 'X-UIDH';
    const X_CSRF_TOKEN = 'X-Csrf-Token';
    const X_REQUEST_ID = 'X-Request-ID';
    const X_CORRELATION_ID = 'X-Correlation-ID';
    const SAVE_DATA = 'Save-Data';
}