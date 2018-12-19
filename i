echo 'Preparations...';
php artisan yasna:flush-init

cd app; rm -rf Models; cd ..
echo 'Models directory deleted!'

cd storage/framework/cache ; rm -rf data; mkdir data ; cd ../../..
echo "Caches directory deleted!"


echo ''
echo 'First Init...'
php artisan yasna:init --no-check

echo ''
echo 'Second Init...'
if [ "$1" = "--no-check" ]; then
	php artisan yasna:init --no-check
else
	php artisan yasna:init
fi

echo ''
echo 'Asset Publish...'
php artisan yasna:assets

# echo ''
# echo 'HEH :D'
