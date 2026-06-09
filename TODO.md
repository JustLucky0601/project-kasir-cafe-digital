# TODO

- [ ] Fix `Undefined variable $chartDailyLabels` on `admin/dashboard` by aligning controller data with Blade chart variables.
- [ ] Update `app/Http/Controllers/AdminController.php` to always pass:
  - `chartDailyLabels`, `chartDailyData`
  - `chartWeeklyLabels`, `chartWeeklyData`
  - `chartMonthDailyLabels`, `chartMonthDailyData`
  - `chartMonthTotalValues` (and any other referenced chart variables)
- [ ] Reload `/admin/dashboard` to confirm no more Blade undefined-variable errors.

