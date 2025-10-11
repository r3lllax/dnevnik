 <h1>Use Git Bash</h1>
<hr>
<h2>Ctrl C + Ctrl V</h2>
cp .env.example .env 

composer install

php artisan key:generate

php artisan migrate --seed 

<hr>
Roles always in this order:

Admin - 1 <br>
Teacher - 2 <br>
Student - 3 <br>
