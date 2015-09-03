<?php

use Phinx\Migration\AbstractMigration;

/**
 * Initial Categories
 */
class InitialCategories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        $this->execute('
        CREATE TABLE "categories" (
"id" BIGSERIAL,
"parent_id" BIGINT,
"tree_left" BIGINT NOT NULL,
"tree_right" BIGINT NOT NULL,
"scope" VARCHAR,
"level" INTEGER,
"slug" VARCHAR NOT NULL,
"title" VARCHAR,
"description" TEXT,
"created_at" TIMESTAMP,
"updated_at" TIMESTAMP,
CONSTRAINT "categories_categories_parent_id_id_foreign" FOREIGN KEY ("parent_id") REFERENCES "categories" ("id") ON UPDATE NO ACTION ON DELETE CASCADE DEFERRABLE INITIALLY IMMEDIATE,
CONSTRAINT "categories_slug_unique" UNIQUE ("slug"),
PRIMARY KEY ("id")
);
CREATE INDEX "categories_scope_index" ON "categories" ("scope");
CREATE INDEX "categories_title_index" ON "categories" ("title");
CREATE INDEX "categories_tree_left_index" ON "categories" ("tree_left");
CREATE INDEX "categories_tree_right_index" ON "categories" ("tree_right");
CREATE INDEX "categories_created_at_index" ON "categories" ("created_at");
CREATE INDEX "categories_updated_at_index" ON "categories" ("updated_at");
        ');
    }
}
