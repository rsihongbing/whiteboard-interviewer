#!/bin/bash

# setup database
mysql -u dannych --password=U6dPvb2m < localhost.sql

# pull codes from github
git init
git remote add origin https://github.com/alsoallison/whiteboard-interviewer.git
git fetch origin master
git pull origin master
git rm -rf files

# allow other people in the group to modify the files
chmod -R 775 *
