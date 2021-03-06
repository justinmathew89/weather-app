<h1>Weather Application</h1>
<h2>Description</h2>
<p>A single page web application that fetches the weather information, 
which involves the current weather data and weather forecast information
for the next 5 days for any city
</p>
<h2>Installation Instructions</h2>
<p>Clone the repository</p>
<code>gh repo clone justinmathew89/weather-app</code>
<p>Configure the database in <code>config/database.php</code> the current configuration on mysql is</p>
<code>
            'database' => env('DB_DATABASE', 'weather_app_prod_db'),<br>
            'username' => env('DB_USERNAME', 'root'),<br>
            'password' => env('DB_PASSWORD', ''),
</code>
<p><code>cd</code> to project directory and run the migration with seed option. This will run the necessary 
migrations to insert the necessary data into the database</p>
<code>php artisan migrate --seed</code>
<p></p>
<p>This will create the cities table and then insert the cities data to the database</p>
<p>Build the application using the following commands</p>
<code>npm install <br>
npm run prod
</code>
<p>This will create the necessary js and css file to the public folders
that are required for the react app to run</p>
<p>Add a <code>VirtualHost</code> entry into apache config that points the <code>DocumentRoot</code> to the
public folder in the project directory</p>
<p>OR use <code>php artisan serve</code> to run using the Laravel test server</p>

<h2>Console Application</h2>
<p>Console application can be used to generate a CSV file of the weather info of any number 
of cities.</p>
<p>To run the console application</p>
<code>php artisan fetchweather [city Names]</code>
<p>where <code>[city Names]</code> can be replaced with the names of cities that
are comma separated.</p>
<p>For example</p>
<code>php artisan fetchweather Delhi,New York,Sydney</code>
<p>The output CSV file with weather info from these cities will be generated in the public folder</p>
