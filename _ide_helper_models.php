<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $start_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereUserId($value)
 */
	class Challenge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $date
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DayGoal|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Goal> $goals
 * @property-read int|null $goals_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DayFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Day whereUserId($value)
 */
	class Day extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $day_id
 * @property string $goal_id
 * @property int $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Day $day
 * @property-read \App\Models\Goal $goal
 * @method static \Database\Factories\DayGoalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal whereDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal whereGoalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DayGoal whereUpdatedAt($value)
 */
	class DayGoal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $title
 * @property string $body
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DayGoal|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Day> $days
 * @property-read int|null $days_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\GoalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Goal whereUserId($value)
 */
	class Goal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Challenge|null $challenge
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Day> $days
 * @property-read int|null $days_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Goal> $goals
 * @property-read int|null $goals_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

