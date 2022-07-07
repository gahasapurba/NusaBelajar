<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AnnouncementSeeder::class,
            ArticleCategorySeeder::class,
            ArticleTagSeeder::class,
            ArticleSeeder::class,
            ArticleTaggedSeeder::class,
            ArticleCommentSeeder::class,
            CheckoutSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            CourseMemberSeeder::class,
            CourseSubTopicSeeder::class,
            CourseMaterialSeeder::class,
            CourseExamSeeder::class,
            CourseExamAnswerSeeder::class,
            CourseCertificateSeeder::class,
            CourseReviewSeeder::class,
            DiscountSeeder::class,
            DiscussionCategorySeeder::class,
            DiscussionSeeder::class,
            DiscussionAnswerSeeder::class,
            EmailSubscriptionSeeder::class,
            EventCategorySeeder::class,
            EventSeeder::class,
            MentorVerificationSeeder::class,
            MessageSeeder::class,
            QuestionnaireSeeder::class,
        ]);
    }
}
