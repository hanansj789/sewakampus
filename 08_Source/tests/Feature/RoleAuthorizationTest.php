<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_student_can_open_student_dashboard(): void
    {
        $student = User::query()->where('role', 'STUDENT')->where('account_status', 'ACTIVE')->firstOrFail();

        $this->actingAs($student)->get('/student/dashboard')->assertOk();
    }

    public function test_student_cannot_open_admin_dashboard_even_with_role_query_parameter(): void
    {
        $student = User::query()->where('role', 'STUDENT')->where('account_status', 'ACTIVE')->firstOrFail();

        $this->actingAs($student)->get('/admin/dashboard?role=ADMIN')->assertForbidden();
    }

    public function test_admin_can_open_admin_dashboard(): void
    {
        $admin = User::query()->where('role', 'ADMIN')->where('account_status', 'ACTIVE')->firstOrFail();

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
    }

    public function test_dashboard_redirects_by_database_role(): void
    {
        $admin = User::query()->where('role', 'ADMIN')->where('account_status', 'ACTIVE')->firstOrFail();

        $this->actingAs($admin)->get('/dashboard')->assertRedirect('/admin/dashboard');
    }
}
