<?php
declare(strict_types=1);

const APP_NAME = 'PAROKO';
const APP_URL = '';
const CURRENCY = '৳';
const DB_PATH = __DIR__ . '/../storage/sqlite.db';
const DEMO_ADMIN_EMAIL = 'admin@paroko.test';
const DEMO_ADMIN_PASSWORD = 'password';

session_name('paroko_session');
session_start();

date_default_timezone_set('Asia/Dhaka');

if (!is_dir(dirname(DB_PATH))) {
    mkdir(dirname(DB_PATH), 0775, true);
}

function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $pdo = new PDO('sqlite:' . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}

function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function money(float|int $n): string { return CURRENCY . number_format((float)$n, 0); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function is_post(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function post(string $key, mixed $default=null): mixed { return $_POST[$key] ?? $default; }
function get(string $key, mixed $default=null): mixed { return $_GET[$key] ?? $default; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(24)); return $_SESSION['csrf']; }
function csrf_input(): string { return '<input type="hidden" name="csrf" value="'.e(csrf_token()).'">'; }
function verify_csrf(): void { if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) { http_response_code(419); exit('CSRF token mismatch'); } }
function flash(string $type, string $message): void { $_SESSION['flash'][] = compact('type','message'); }
function flashes(): array { $x = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $x; }
function user(): ?array { return $_SESSION['user'] ?? null; }
function admin(): bool { return in_array((user()['role'] ?? ''), ['admin','manager','editor'], true); }
function permissions(): array { $raw=(string)(user()['permissions']??''); $x=json_decode($raw,true); return is_array($x)?$x:[]; }
function can_manage(string $key): bool { if((user()['role']??'')==='admin') return true; return !empty(permissions()[$key]); }
function require_admin(): void { if (!admin()) redirect('/admin/login.php'); }
function setting_json(string $key, mixed $default=[]): mixed { $v=setting($key,''); if($v==='') return $default; $x=json_decode($v,true); return $x===null?$default:$x; }
function post_type_label(string $type): string { return match($type){'gadgets'=>'Gadgets','jersey'=>'Jersey','fashion'=>'Fashion','articles'=>'Articles','docs'=>'Docs','pages'=>'Pages',default=>ucwords(str_replace('_',' ',$type))}; }
function content_url(string $type,string $slug): string { return '/'.$type.'/'.rawurlencode($slug); }
function slugify(string $s): string { $s = strtolower(trim($s)); $s = preg_replace('/[^a-z0-9]+/','-',$s) ?? ''; return trim($s,'-') ?: 'item-' . time(); }
function setting(string $key, string $default=''): string { $st=db()->prepare('SELECT value FROM settings WHERE key=?'); $st->execute([$key]); $v=$st->fetchColumn(); return $v===false?$default:(string)$v; }
function json_response(array $data, int $status=200): never { http_response_code($status); header('Content-Type: application/json'); echo json_encode($data, JSON_UNESCAPED_UNICODE); exit; }
function base_path(string $p=''): string { return rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/') . '/' . ltrim($p,'/'); }
function current_niche(): string { $n=(string)get('niche',''); if(in_array($n,['gadgets','jersey','fashion'],true))return $n; $path=parse_url($_SERVER['REQUEST_URI']??'',PHP_URL_PATH)?:''; $seg=trim(explode('/',trim($path,'/'))[0]??'',' '); return in_array($seg,['gadgets','jersey','fashion'],true)?$seg:'gadgets'; }
function cart(): array { return $_SESSION['cart'] ?? []; }
function cart_count(): int { return array_sum(array_map(fn($i)=>(int)$i['qty'], cart())); }
function cart_totals(): array {
    $subtotal = 0;
    foreach (cart() as $item) $subtotal += ((float)$item['price'] * (int)$item['qty']) + (float)($item['printing_charge'] ?? 0);
    $shipping = $subtotal >= 3000 ? 0 : (float)setting('shipping_inside','120');
    $discount = (float)($_SESSION['coupon_discount'] ?? 0);
    $total = max(0, $subtotal + $shipping - $discount);
    return compact('subtotal','shipping','discount','total');
}
function image_or_placeholder(?string $image, string $label): string { return $image ?: 'https://placehold.co/700x700/f1f5f9/111827?text='.rawurlencode($label); }


function storage_private_dir(string $sub=''): string {
    $base = __DIR__.'/../storage/private';
    if (!is_dir($base)) @mkdir($base, 0775, true);
    $dir = $base . ($sub ? '/'.trim($sub,'/') : '');
    if (!is_dir($dir)) @mkdir($dir, 0775, true);
    return $dir;
}
function public_upload_dir(string $sub=''): string {
    $base = __DIR__.'/../uploads';
    if (!is_dir($base)) @mkdir($base, 0775, true);
    $dir = $base . ($sub ? '/'.trim($sub,'/') : '');
    if (!is_dir($dir)) @mkdir($dir, 0775, true);
    return $dir;
}
function upload_error_message(int $code): string {
    return match($code){UPLOAD_ERR_INI_SIZE=>'File exceeds server upload limit',UPLOAD_ERR_FORM_SIZE=>'File exceeds form upload limit',UPLOAD_ERR_PARTIAL=>'File upload was incomplete',UPLOAD_ERR_NO_FILE=>'No file selected',default=>'Upload failed'};
}
function save_public_upload(array $file, array $allowedExt, int $maxBytes=12000000, string $folder='media'): array {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) throw new RuntimeException(upload_error_message((int)($file['error'] ?? UPLOAD_ERR_NO_FILE)));
    $size=(int)($file['size'] ?? 0); if($size<=0 || $size>$maxBytes) throw new RuntimeException('File size is invalid or too large.');
    $ext=strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if(!in_array($ext,$allowedExt,true)) throw new RuntimeException('Unsupported file type: '.$ext);
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) ?: 'application/octet-stream';
    $safe = date('YmdHis').'-'.bin2hex(random_bytes(5)).'.'.$ext;
    $dir=public_upload_dir($folder);
    if(!move_uploaded_file($file['tmp_name'],$dir.'/'.$safe)) throw new RuntimeException('Could not save uploaded file.');
    return ['filename'=>$file['name'],'stored'=>$safe,'path'=>'/uploads/'.$folder.'/'.$safe,'mime'=>$mime,'size'=>$size,'dir'=>$dir.'/'.$safe,'ext'=>$ext];
}
function save_private_download(array $file, array $allowedExt=['zip'], int $maxBytes=250000000, string $folder='downloads'): array {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) throw new RuntimeException(upload_error_message((int)($file['error'] ?? UPLOAD_ERR_NO_FILE)));
    $size=(int)($file['size'] ?? 0); if($size<=0 || $size>$maxBytes) throw new RuntimeException('File size is invalid or too large.');
    $ext=strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if(!in_array($ext,$allowedExt,true)) throw new RuntimeException('Only ZIP files are allowed for digital downloads.');
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) ?: 'application/zip';
    $safe=bin2hex(random_bytes(20)).'.'.$ext;
    $dir=storage_private_dir($folder);
    if(!move_uploaded_file($file['tmp_name'],$dir.'/'.$safe)) throw new RuntimeException('Could not save protected file.');
    return ['filename'=>$file['name'],'stored_path'=>$dir.'/'.$safe,'mime'=>$mime,'size'=>$size,'ext'=>$ext];
}
function user_has_purchased_product(int $userId, int $productId): bool {
    if($userId<=0 || $productId<=0) return false;
    $st=db()->prepare("SELECT COUNT(*) FROM orders o JOIN order_items oi ON oi.order_id=o.id WHERE o.customer_id=? AND oi.product_id=? AND o.order_status NOT IN ('cancelled','returned','refunded')");
    $st->execute([$userId,$productId]); return (int)$st->fetchColumn()>0;
}
function make_download_token(int $userId, int $productId, int $fileId): string {
    $token=bin2hex(random_bytes(32));
    db()->prepare('INSERT INTO download_tokens(token,user_id,product_id,file_id,expires_at) VALUES(?,?,?,?,datetime(\'now\',\'+15 minutes\'))')->execute([$token,$userId,$productId,$fileId]);
    return $token;
}
function render_shortcodes(string $html): string {
    return preg_replace_callback('/\[([a-z0-9\-_]+)\]/i', function($m){
        $st=db()->prepare('SELECT content,content_type,status FROM shortcodes WHERE code=? LIMIT 1'); $st->execute(['['.$m[1].']']); $r=$st->fetch();
        if(!$r || !(int)$r['status']) return $m[0];
        return $r['content_type']==='html' ? (string)$r['content'] : nl2br(e((string)$r['content']));
    }, $html) ?? $html;
}
