Roblox Mobile Forums
====================

[Development site](http://robloxforums-ericwieser.rhcloud.com/)

Setting up your own instance on openshift for development
---------------------------------------------------------

1. Install the openshift command line tools
2. Create an openshift account
3. Create a new node.js 0.6.0 app from an existing git repo (this one)
4. Follow the steps [here](https://github.com/smarterclayton/openshift-redis-cart)
5. The app restarts whenever you push
6. To view the logs, run `rhc tail <appname>`

Developing locally on windows
-----------------------------

_**Note:** redis connections do not currently work, but the rest of the site is alright_

1. Install the latest version of [node.js](http://nodejs.org/)
2. Get the unofficial windows port of redis from [here](https://github.com/MSOpenTech/redis/blob/2.6/bin/release/), and add the executables to your path
3. In an empty folder somewhere, run `redis-server`
4. In the repo directory:
  * `npm install`
  * `npm start`
