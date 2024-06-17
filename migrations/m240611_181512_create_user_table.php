<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240611_181512_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Creates index for column `username`
        $this->createIndex(
            'idx-user-username',
            '{{%user}}',
            'username'
        );

        // Creates index for column `email`
        $this->createIndex(
            'idx-user-email',
            '{{%user}}',
            'email'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drops indexes
        $this->dropIndex(
            'idx-user-username',
            '{{%user}}'
        );

        $this->dropIndex(
            'idx-user-email',
            '{{%user}}'
        );

        // Drops table
        $this->dropTable('{{%user}}');
    }
}
