#Setting LocalServer (Apace-MySql-PHP) untuk Web Development dengan Ubuntu

Ya, ini adalah tutorial ringkas (lebih kepada nota untuk diri sendiri) tentang langkah-langkah yang perlu diambil ke atas sebuah komputer dengan OS Ubuntu untuk memudahkan proses pembangunan laman web.

![Ubuntu](../images/webdev.png)

Mengapa Ubuntu? Kerana ianya linux dan kebanyakan server online adalah linux dengan flavor Ubuntu. Semakin dekat spesifikasi development server dengan production server semakin bagus kerana semakin kurang bugs yang akan muncul.

Langkah awal sebelum mula adalah: Install Ubuntu Desktop (terbaru adalah 14.04 LTS semasa artikel ini ditulis) dan ikut banyak tutorial yang ada di online untuk install Apache2 MySQL dan juga PHP. Ia cukup mudah.

Pastikan semua telah diinstall dengan baik dengan cara buka laman web http://localhost di browser kita.

Apabila kita ingin menghasilkan projek baru, kita perlu menyediakan tapak coding untuk projek website tersebut.

Berikut adalah langkah-langkahnya:

##1) Buat Folder baru di Desktop

Saya suka biarkan koding untuk semua projek saya dalam satu folder khas di Desktop. Ini memudahkan saya mencapai kod tersebut dan mudah untuk kita gunakan dan ejas assets yang diperlukan.

Buka Terminal dan run kod berikut:

	$ mkdir ~/Desktop/localhost/blog

Semak dan pastikan folder tersebut telah muncul di desktop.

##2) Buat shortcut ke folder di desktop tadi di dalam folder /var/www/html

Ini adalah kod yang spesifik. Kita mahu shortcut ke folder blog di dalam folder html. Bukan sebaliknya. Jika sebaliknya nanti kita tidak boleh edit kod projek kita kerana ianya milik root (semua fail dalam folder html adalah milik root/apache).

Run kod berikut:

	$ ln -s ~/Desktop/localhost/blog /var/www/html

Semak untuk pastikan shortcut telah dibina dengan lihat senarai isi dalam folder html:

	$ ls /var/www/html

##3) Setup VirtualHost Config untuk Apache

VirtualHost adalah ibarat dalam satu server Apache kita boleh run banyak projek website bawah setting masing-masing. Antara setting yang penting dalam config adalah servername, documentroot dan juga allow access.

Jika ini adalah fresh install, kita perlu sediakan satu template config terlebih dahulu.

Bina satu fail text seperti berikut:

	$ touch /etc/apache2/sites-available/template.conf

Kemudian kita edit fail tersebut dengan menggunakan aplikasi gedit dengan permission sebagai root:

	$ gksudo gedit /etc/apache2/sites-available/template.conf

Aplikasi dengan rupa ala-ala notepad akan muncul. Copy dan paste teks berikut:

	<VirtualHost *:80>
		ServerName template.dev
		ServerAdmin webmaster@localhost
		DocumentRoot /var/www/html/template
		
		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.combined log

		<Directory /var/www/html/template/>
		    AllowOverride All
		    Order allow,deny
		    allow from all
		</Directory>
	</VirtualHost>

Baik, save fail tersebut (ctrl+S) dan tutup aplikasi gedit tadi.

Setelah ada template barulah kita boleh duplicate untuk projek website blog kita tadi:

	$ sudo cp /etc/apache2/sites-available/template.conf /etc/apache2/sites-available/blog.conf

Perkara yang paling penting di sini adalah pastikan setiap fail config kita menggunakan filetype: .conf . Jika tidak apache tidak akan kenal dan website kita tidak boleh diakses.

##4) Edit Config mengikut Projek Kita

Setiap projek ada perbezaan. Paling biasa adalah segala kod bagi satu-satu projek biasanya diletak dalam satu folder. Maka kita perlu pastikan apache jumpa kod yang betul apabila domain namenya dipanggil.

Untuk berbuat demikian, kita perlu edit config setting tadi.

Buka fail config menggunakan gedit:

	$ gksudo gedit /etc/apache2/sites-available/blog.conf

Dan ubahsuai mengikut nota seperti berikut:

	<VirtualHost *:80>
		# ServerName adalah domainname yang kita mahu guna untuk access daripada browser. Saya mahu guna http://blog.dev
		ServerName blog.dev

		ServerAdmin webmaster@localhost
		
		# DocumentRoot adalah folder dimana letaknya kod-kod untuk projek kita. Saya letak dalam folder blog:
		DocumentRoot /var/www/html/blog
		
		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.combined log

		# Ini adalah setting untuk access dan juga htaccess. Tukar kepada folder projek kita. Pastikan hujungnya ada slash '/'
		<Directory /var/www/html/blog/>
		    AllowOverride All
		    Order allow,deny
		    allow from all
		</Directory>
	</VirtualHost>

Setelah siap ubahsuai kita save (ctrl+s) dan tutup gedit.

##5) Enable site untuk diakses

Kita perlu activate config tadi supaya Apache boleh mengesannya secara live di locaserver. Run command berikut:

	$ sudo a2ensite blog.conf

##6) Edit Host File untuk Locaserver

Kemudian kita perlu mengubahsuai hosts file untuk memastikan komputer kita memanggil server Apache dalam komputer kita apabila kita melayari http://blog.dev

Buka fail hosts dengan gedit:

	$ gksudo gedit /etc/hosts

Dan tambah kod ini di barisan baru:

	127.0.0.1 blog.dev

Save dan tutup gedit.

##7) Restart Apache

Apabila semua sudah siap, kita perlu restart/reload servis apache untuk membolehkan apache menggunakan config projek kita yang terbaru.

	$ sudo service apache2 restart

Dan kini, apabila kita pergi ke http://blog.dev di browser kita, kita dapat lihat segala kod php kita berjalan dengan lancar.

Boleh cuba buat fail baru dalam folder projek kita untuk memastikannya:

1. Pergi ke dalam folder blog di desktop.
2. klik kanan dan pilih menu 'New Document'
3. letak nama dail tersebut 'info.php'
4. Masukkan kod berikut dalam fail tadi: `<?php phpinfo();?>`
5. Save dan reload page http://blog.dev di browser.

Jika ia menjadi maka paparan maklumat PHP akan muncul dengan lengkap.

Harapnya ia menjadilah. Jika tidak kita perlu troubleshoot atau ulang semula langkah-langkah di atas. TT___TT