<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * This migration is used to delete courses_instructors table and instead create a offerings_instructors table.
 * The data would also habe to be migrated to the new table
 */
class Version20120126014843 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        
        // Create the offerings_instructors table first
        $this->addSql("CREATE  TABLE IF NOT EXISTS `offerings_instructors` (
                      `id` INT NOT NULL AUTO_INCREMENT ,
                      `offering_id` INT NOT NULL ,
                      `instructor_id` INT NOT NULL ,
                      PRIMARY KEY (`id`) ,
                      INDEX `offerings_instructors.offering_id` (`offering_id` ASC) ,
                      INDEX `offerings_instructors.instructor_id` (`instructor_id` ASC) ,
                      CONSTRAINT `offerings_instructors.offering_id`
                        FOREIGN KEY (`offering_id` )
                        REFERENCES `offerings` (`id` )
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION,
                      CONSTRAINT `offerings_instructors.instructor_id`
                        FOREIGN KEY (`instructor_id` )
                        REFERENCES `instructors` (`id` )
                        ON DELETE NO ACTION
                        ON UPDATE NO ACTION)
                      ENGINE = InnoDB;");
                
        $data = $this->connection->fetchAll("SELECT ci.*, o.id as offering_id FROM courses_instructors ci LEFT JOIN offerings o ON o.course_id = ci.course_id");
        foreach($data as $row){
            $query = "INSERT INTO offerings_instructors(offering_id,instructor_id) VALUES(%d,%d)";
            $this->addSql(sprintf($query,$row['offering_id'], $row['instructor_id']));
        }
        
       $this->sm->dropTable('courses_instructors');

    }

    public function down(Schema $schema)
    {
        $this->throwIrreversibleMigrationException();

    }
}
