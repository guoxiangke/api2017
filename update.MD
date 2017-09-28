cd /var/www/
wget https://ftp.drupal.org/files/projects/drupal-8.3.7.zip
unzip drupal-8.3.7.zip
mv drupal-8.3.7 newdrupal
git clone https://github.com/guoxiangke/api2017.git
cp -rf api2017/.git newdrupal/
cd newdrupal/
git checkout .

THEN cp oldsitefiles2newdrupal!!!
cp ../api/sites/default/* sites/default/ -rf
