changed=1
unDepotMaj=0
dossierCourant=$(pwd)
modules=( $dossierCourant )
parameter=$1

# vide l'écran
clear

FILE=update_sh_config.cfg
if [ ! -f "$FILE" ]; then
	echo "le fichier de config n'existe pas"
	exit
fi 

# import du fichier de config
. update_sh_config.cfg

if [ -z $dockerweb ]; then
	echo "impossible de trouver la variable du nom du docker : dockerweb dans le fichier de config"
	exit
fi

# deplacement dans le dossier des modules /App
cd $dossierCourant/App;

# Recherche les différents dossier
for inode in $(ls); do
	if [ -d $inode ]; then
		modules+=( $dossierCourant/App/$inode )
	fi
done

for module in "${modules[@]}"; do
	cd $module

	changed=1
	git remote update && git status -uno | grep 'Your branch is up to date' && changed=0
	if [ $changed = 1 ]; then
		unDepotMaj=1

		echo Mise à jour du module : $module

		# mise à jour des fichiers
		git pull
	fi
done

if [ ${parameter:-faux} = "--force" ]; then
	unDepotMaj=1
fi

# Une mise à jour a été effectuée
if [ $unDepotMaj = 1 ]; then
	echo "un depot a été mis à jour : $dossierCourant"

	# retour dans le dossier racine
	cd $dossierCourant

	# lancement de composer
	docker exec $dockerweb php composer.phar update
	
	# lancement des mises à jour des entités
	docker exec $dockerweb php zeapps migrate

	# vide le cache
	docker exec $dockerweb php zeapps clear:cache
fi