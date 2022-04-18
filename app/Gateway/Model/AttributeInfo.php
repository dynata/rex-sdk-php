<?php

namespace Dynata\Rex\Gateway\Model;

class AttributeInfo
{
    public int $id;
    public string $name;
    public string $description;
    public ?string $display_name;
    public ?array $parent_dependencies;
    public ?int $expiration_duration;
    public bool $is_active;
    public ?array $countries;
    public ?array $answers;
    public ?QuestionItem $question;
}
