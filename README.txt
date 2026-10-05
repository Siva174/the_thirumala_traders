THIRUMALA TRADERS WEBSITE (PHP, no database)

Run locally (needs PHP 7.4+):
  cd thirumala-traders
  php -S localhost:8000
Open http://localhost:8000  |  Admin: http://localhost:8000/admin/

Admin login (change in inc/functions.php): admin / thirumala@123

Files you add:
  assets/construction.mp4  - your friend's construction video (home page)
  assets/trader.gif        - shop GIF (about page)

Data: products are saved in data.txt (JSON). Product photos are saved in prodpic/.
Both must be writable by the web server.
