# TODO: Update Seeders for All Models

## Overview
Check all models in app/Models/ and ensure corresponding seeders exist in database/seeders/. Create missing seeders with sample data that maintains relationships. Update DatabaseSeeder to call all seeders in dependency order.

## Existing Seeders (14)
- UserSeeder ✓
- InstructorSeeder ✓
- CadetSeeder ✓
- UniformCategorySeeder (for UniformType) ✓
- UniformComponentSeeder ✓
- CadetSizeSeeder ✓
- TrainingSeeder ✓
- LearningMaterialCategorySeeder ✓
- LearningMaterialSeeder ✓
- QuizQuestionSeeder ✓
- AttendanceSeeder (for TrainingAttendance) ✓
- BadgeSeeder ✓
- ContentSettingsSeeder (exists but not called) - Add to DatabaseSeeder

## Missing Seeders (10)
- ApplicationSeeder
- CadetBadgeSeeder
- CadetCategoryProgressSeeder
- CadetLearningMaterialProgressSeeder
- CadetQuizScoreSeeder
- EquipmentLoanSeeder
- GallerySeeder
- GalleryCategorySeeder
- InventoryItemSeeder
- PerformanceRatingSeeder

## Steps
1. Update DatabaseSeeder.php to include ContentSettingsSeeder and new seeders in dependency order.
2. Create ApplicationSeeder.php
3. Create CadetBadgeSeeder.php
4. Create CadetCategoryProgressSeeder.php
5. Create CadetLearningMaterialProgressSeeder.php
6. Create CadetQuizScoreSeeder.php
7. Create EquipmentLoanSeeder.php
8. Create GalleryCategorySeeder.php
9. Create GallerySeeder.php
10. Create InventoryItemSeeder.php
11. Create PerformanceRatingSeeder.php
12. Run php artisan db:seed to test all seeders work correctly.

## Dependency Order for DatabaseSeeder
- UserSeeder
- ContentSettingsSeeder
- InstructorSeeder
- CadetSeeder
- UniformCategorySeeder
- UniformComponentSeeder
- CadetSizeSeeder
- TrainingSeeder
- LearningMaterialCategorySeeder
- LearningMaterialSeeder
- QuizQuestionSeeder
- AttendanceSeeder
- BadgeSeeder
- ApplicationSeeder
- CadetBadgeSeeder
- CadetCategoryProgressSeeder
- CadetLearningMaterialProgressSeeder
- CadetQuizScoreSeeder
- EquipmentLoanSeeder
- GalleryCategorySeeder
- GallerySeeder
- InventoryItemSeeder
- PerformanceRatingSeeder
