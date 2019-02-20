---
title: 'Build Script'
---

! This may not make any sense, but it might help someone. The bash script was what I wrote to create multiple document builds from Sphinx within Jenkins. This script is run each time that build compiles, ensuring version controlled documents.

```sh
#!/bin/bash -xe

echo "Starting Sphinx Documentation generation."

rm -rf Artifacts

####################################################
# Ensure Sphinx is installed with its dependencies #
####################################################

#ADD VERSION FOR SPHINX AND TEMPLATE


if [ ! -d "./makethedocs" ]; then
  sudo apt-get update -y
  sudo apt-get upgrade -y
  sudo apt-get dist-upgrade -y
  sleep 4s
  sudo apt-get install python-pip
  sudo pip install --upgrade pip
  sudo pip install virtualenv
  sudo virtualenv --always-copy makethedocs
  sudo pip install sphinx
  sudo pip install sphinx_rtd_theme
  sudo apt-get install texlive-full -y
  sudo pip install recommonmark
fi

#####

##########################################
# Run the process for creating DocSystem #
##########################################

#####################################################
# ! > Remember docsys is for internal use only. < ! #
#  - - - - - - - - - - - - - - - - - - - - - - - -  #
# The DocSystem is designed to record instructions  #
# for this Sphinx system. Record process here.      #
#####################################################

# Descend into the Release Notes project folder.

cd docsystem

# Make sure any prior build content is deleted before recreating.
rm -rf build

# Run the HTML generation.
make html

# This ascends out of the Release Notes project.
cd ..

echo "I am done running docsys"
echo $PWD
#####

##############################################
# Run the process for creating Analyst Guide #
##############################################

# ** This is commented out until created. **

# Descend into the Analyst Guide project folder.
#cd anguide

# Make sure any prior build content is deleted before recreating.
#rm -rf build

# Run the HTML generation.
#make html

# This ascends out of the Analyst Guide project.
#cd ..

#echo "I am done running anguide"
#echo $PWD
#####

##############################################
# Run the process for creating Release Notes #
##############################################

# Descend into the Release Notes project folder.
cd relnotes

# Make sure any prior build content is deleted before recreating.
rm -rf build

# Run the HTML generation.
make html

# This ascends out of the Release Notes project.
cd ..

echo "I am done running relnotes"
echo $PWD
#####

################################################
# Run the process for creating Technical Notes #
################################################

# Descend into the Technical Notes project folder.
cd technotes

# Make sure any prior build content is deleted before recreating.
rm -rf build

# Run the HTML generation.
make html

# This ascends out of the Technical Notes project.
cd ..


echo "I am done running technotes"
echo $PWD
#####

#########################################################
# Run the process for creating Install and Config Guide #
#########################################################

# Descend into the Install and Config project folder.
cd install

# Make sure any prior build content is deleted before recreating.
#rm -rf build

# Run the HTML generation.
#make html

# Run the Latex and PDF generation
#sphinx-build -b latex source build

# Drop into the /build directory
cd build

# Run the Latex to PDF Conversion
#pdflatex filenamehere.tex

# This ascends out of the Install and Config project.
cd ..
cd ..

echo "I am done running install"
echo $PWD
#####

###########################################################
# Run the process for creating System Administrator Guide #
###########################################################

# Descend into the System Administrator project folder.
cd sysadmin

# Make sure any prior build content is deleted before recreating.
#rm -rf build

# Run the HTML generation.
#make html

# Run the Latex and PDF generation
#sphinx-build -b latex source build

# Drop into the /build directory
cd build

# Run the Latex to PDF Conversion
#pdflatex filenamehere.tex

# This ascends out of the System Administrator project.
cd ..
cd ..

echo "I am done running sysadmin"
echo $PWD
#####

##############################################
# Run the process for creating Log Reference #
##############################################

# Descend into the Log Reference project folder.
cd logref

# Make sure any prior build content is deleted before recreating.
#rm -rf build

# Run the HTML generation.
#make html

# Run the Latex and PDF generation
#sphinx-build -b latex source build

# Drop into the /build directory
cd build

# Run the Latex to PDF Conversion
#pdflatex filenamehere.tex

# This ascends out of the Log Reference project.
cd ..
cd ..

echo "I am done running logref"
echo $PWD
#####

############################################################
# Move the built products into /Artifacts for distribution #
############################################################

mkdir Artifacts
mkdir Artifacts/docs
mkdir Artifacts/docs/install
mkdir Artifacts/docs/logref
mkdir Artifacts/docs/relnotes
mkdir Artifacts/docs/sysadmin
mkdir Artifacts/docs/technotes
mkdir Artifacts/zips

cp index.html Artifacts/docs/.
cp -R css Artifacts/docs/css
cp -R fonts Artifacts/docs/fonts
cp -R js Artifacts/docs/js

cp -R install/build Artifacts/docs/install
cp -R logref/build Artifacts/docs/logref
cp -R relnotes/build Artifacts/docs/relnotes
cp -R sysadmin/build Artifacts/docs/sysadmin
cp -R technotes/build Artifacts/docs/technotes

#############################
# Create a zip file package #
#############################

cd Artifacts/docs
zip -r ../zips/docs.zip .
cd ..



#############################
# Thanks for joining us. :) #
#############################
# SOMEVAR='Should be done, homie.'
# echo "$SOMEVAR"
# read -p "Press any key to exit > " -n1 junk
# echo

```