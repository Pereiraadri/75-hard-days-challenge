<?php

namespace App;

enum ChallengeStatus: string
{
    case Created = 'created';
    case Running = 'running';
    case Finished = 'finished';
}
