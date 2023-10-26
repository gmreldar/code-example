<?php

declare(strict_types=1);

namespace Modules\Garage\Tests\Feature\Domain\Rules;

use Modules\Garage\Domain\Rules\IsCurrentMileageMoreThenInitialRule;
use Tests\TestCase;

class IsCurrentMileageMoreThenInitialRuleTest extends TestCase
{
    public function testItValidatesWhenCurrentMileageIsMoreThanInitial(): void
    {
        $initialMileage = 100;
        $rule = new IsCurrentMileageMoreThenInitialRule($initialMileage);

        $this->assertTrue($rule->passes('', 101));
    }

    /** @test */
    public function testItDoesNotValidateWhenCurrentMileageIsLessThanInitial(): void
    {
        $initialMileage = 100;
        $rule = new IsCurrentMileageMoreThenInitialRule($initialMileage);

        $this->assertFalse($rule->passes('', 99));
    }

    /** @test */
    public function testItValidatesWhenCurrentMileageIsEqualToInitial(): void
    {
        $initialMileage = 100;
        $rule = new IsCurrentMileageMoreThenInitialRule($initialMileage);

        $this->assertTrue($rule->passes('', 100));
    }

    /** @test */
    public function testItReturnsCorrectMessage(): void
    {
        $initialMileage = 100;
        $rule = new IsCurrentMileageMoreThenInitialRule($initialMileage);

        $this->assertEquals('Текущий пробег должен быть больше начального', $rule->message());
    }
}
