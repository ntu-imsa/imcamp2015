NTU IM Camp 2015
===========

Every summer, students at the Department of Information Management, National Taiwan University holds a summer camp for high school students. In NTU IM Camp, high school students will have a chance to know more about NTU, as well as the field of Information Management. This is the repository for the website of NTU IM Camp 2015.

## Requirement
* PHP 5.5
* MySQL 5.6

## Getting Started

**Composer** is used as the dependency manager for PHP in this project, to install **Composer**, you may run the following command in Terminal.

	# Download and install Composer to current directory
	curl -sS https://getcomposer.org/installer | php
	# Move Composer for global access
	sudo mv composer.phar /usr/local/bin/composer

To install required libraries (such as Slim Framework and Facebook PHP SDK) automatically, you may use the following command.

	composer install

After installing those required libraries, remember to make a copy of **config.example.php** located in **includes/** and name it **config.php**, you'll have to edit **config.php** to meet your environment before it works.

With the aid of RedBean ORM, as long as you set up the database credentials, you don't have to set up the database schema manually.

## Credits
- [Shouko](https://github.com/shouko)
