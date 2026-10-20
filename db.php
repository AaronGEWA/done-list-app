<?php    
    $db = new PDO('sqlite:data.sqlite');
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'CREATE TABLE IF NOT EXISTS "projects" (
	"id" INTEGER NOT NULL UNIQUE,
	"title" TEXT NOT NULL,
	"description" TEXT NOT NULL,
	"abschlussdatum" DATE,
	"status" TEXT NOT NULL,
	PRIMARY KEY("id")
    );';
    $db->exec($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS "user" (
	"username" TEXT NOT NULL UNIQUE,
	"password_hash" TEXT NOT NULL,
	PRIMARY KEY("username")
    );';
    $db->exec($sql);
?>