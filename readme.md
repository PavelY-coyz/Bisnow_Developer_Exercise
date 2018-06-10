# Bisnow_Developer_Exercise
Clone the repo
run 'composer install'
run 'npm install'

rename .env.example to .env and fill in your local environment variables

run 'php artisan migrate'
run 'php artisan db:seed' to seed the database

The site should be ready to use.

-----------------------------------------------------------

The  summarize_tracking_data table is filled via a Cron job. The cron.bat file
can be found in the root directory of the project. However, you will need to
setup your own task scheduler in your local environment to run the cron.bat file.

Go to app\Console\Kernel.php for instructions on force-running the scheduler.
