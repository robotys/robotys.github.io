# Codeigniter WORKING htaccess

Ini sekadar nota kepada diri sendiri tentang programming.

Inilah kod htaccess yang boleh jalan untuk gunakan bersama CodeIgniter:

	RewriteEngine On
	RewriteBase /

	RewriteCond %{REQUEST_URI} ^system.*
	RewriteRule ^(.*)$ /index.php?/$1 [L]

	RewriteCond %{REQUEST_URI} ^application.*
	RewriteRule ^(.*)$ /index.php?/$1 [L]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ /index.php?/$1 [L]

Ini jika kita tidak localhost dalam url. Atau kita gunakan servername dalam CodeIgniter kita.

Kalau kita guna subdirectory dalam localhost atau www, kita boleh ubah htaccess tersebut menjadi:

	RewriteEngine On
	RewriteBase /

	RewriteCond %{REQUEST_URI} ^system.*
	RewriteRule ^(.*)$ /subdirectory/index.php?/$1 [L]

	RewriteCond %{REQUEST_URI} ^application.*
	RewriteRule ^(.*)$ /subdirectory/index.php?/$1 [L]

	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ /subdirectory/index.php?/$1 [L]

Ya, semudah itu sahaja.

Sekian,