#!/usr/bin/env perl
use strict;

print "Welcome to the LTC MMO installer\n\n";
print "We need to know a few things to get this going.\n";
print "What host is the database on? ";
my $host = <STDIN>;
print "What username will be connecting as? ";
my $username = <STDIN>;
print "What is the password for that user? ";
my $password = <STDIN>;
print "What is the name of the database? ";
my $database = <STDIN>;

chomp($host);
chomp($username);
chomp($password);
chomp($database);

##### Checking for the configuration files #####
my $configfile = "config.php";
my $databasefile = "database.php";
my $basedir = "../engine/";
my $configdir = "config/";
my $config_fullpath = $basedir . $configdir . $configfile;
my $database_fullpath = $basedir . $configdir . $databasefile;
my $sqlfile = "../cloudrealms.sql";

if ( -d $basedir){
	print " - Found basedir\n";
} else {
	print "This file should be run from the installer directory.\n";
	exit;
}

if ( -d $basedir . $configdir){
	print " - Found configdir\n";
} else {
	print "This file should be run from the installer directory.\n";
	exit;
}

if ( -e $config_fullpath){
	print " - Found the config file\n";
} else {
	print "Couldn't find the config file.  Check for " . $basedir . $configdir . $configfile . "\n";
	exit;
}

if ( -e $database_fullpath){
	print " - Found the databse file.\n";
} else {
	print "Couldn't find the config file.  Check for " . $basedir . $configdir . $databasefile . "\n";
	exit;
}

if ( -e $sqlfile) {
	print " - Found the sql file. Time to being.\n\n";
} else {
	print "Couldn't find the sql file. Reloading the database will fail if you try to do that. We looked for the file in $sqlfile\n";
}

############ END CHECKS ##########
############ BEGIN MODIFICATIONS #############
open(DATABASE,"$database_fullpath");
my @d = <DATABASE>;
close(DATABASE);

foreach (@d){
	if ($_ =~ m/hostname/){
		$_ =~ s/localhost/$host/;
	}
	if ($_ =~ m/username/){
		$_ =~ s/root/$username/;
	}
	if ($_ =~ m/password/){
		$_ =~ s/''/'$password'/;
	}
	if ($_ =~ m/database/){
		$_ =~ s/cloudrealms/$database/;
	}
}

open(DATABASE,">$database_fullpath");
print DATABASE @d;
close(DATABASE);

open(CONFIG,"$config_fullpath");
my @c = <CONFIG>;
close(CONFIG);

foreach (@c){
	if($_ =~ m/index_page/){
		$_ =~ s/''/'index.php'/;
	}
}

open(CONFIG,">$config_fullpath");
print CONFIG @c;
close(CONFIG);
print "Done modifying program files.\n";
########### DONE MODIFYING #################
########### LOAD THE DATABASE ##############
print "Would you like to load a fresh copy of the database?(y/n) ";
my $load_database = <STDIN>;
chomp($load_database);

if($load_database eq 'y' || $load_database eq 'Y'){
	print "Did you already have a copy of the database running?(y/n) ";
	my $previous = <STDIN>;
	chomp($previous);
	if($previous eq 'y' || $previous eq 'Y'){
		print "Old database name: ";
		my $old_database = <STDIN>;
		chomp($old_database);
		print "Dropping database\n";
		print "Enter mysql root password. ";
		`mysqladmin -u root -p -f drop $old_database`;
	}
	print "Loading the database.\n";
	print "Enter mysql root password. ";
	`mysqladmin -u root -p create $database`;
	`mysql -u root -p $database < $sqlfile`;
	print "Done loading the database.\n";
}
print "All done.\n";
