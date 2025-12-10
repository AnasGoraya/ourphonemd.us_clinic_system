# Standardize Action Button Styling

## Tasks
- [ ] Remove redundant action-btn styles from dashboard.blade.php
- [ ] Remove redundant action-btn styles from profile.blade.php

## Information Gathered
- The `action-btn` styles are properly defined in `resources/views/layouts/patient.blade.php` with `!important` declarations
- These styles are duplicated and inconsistently overridden in `dashboard.blade.php` and `profile.blade.php`
- Removing the duplicates will ensure consistent styling across all patient pages

## Plan
1. Edit `resources/views/patient/dashboard.blade.php` to remove the redundant `.action-btn`, `.action-btn.secondary`, `.action-btn:hover`, and `.action-btn.secondary:hover` styles
2. Edit `resources/views/patient/profile.blade.php` to remove the redundant `.action-btn`, `.action-btn.secondary`, and `.action-btn:hover, .action-btn.secondary:hover` styles

## Followup Steps
- Test the styling on patient pages to ensure consistency
- Verify that buttons still function correctly
