#! /bin/bash
#push to github

# git add -A 
# git commit -m "maj"
# git push origin master
git add -A 
if [[ $1 != '' ]]
then
    git commit -m $1
else
    git commit -m "maj"
fi
git push origin master