<?php

declare(strict_types=1);

namespace Dynata\Rex\Registry\Model;

class Opportunity
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_PAUSED = 'PAUSED';
    const STATUS_CLOSED = 'CLOSED';

    const EVALUATION_STARTS = 'STARTS';
    const EVALUATION_COMPLETES = 'COMPLETES';

    const DEVICE_MOBILE = 'mobile';
    const DEVICE_DESKTOP = 'desktop';
    const DEVICE_TABLET = 'tablet';

    public int $id;
    /**
     * @var string One of the STATUS_* constants
     */
    public string $status;
    public int $lengthOfInterview;
    public int $incidenceRate;
    public float $costPerInterview;
    public int $completes;
    public int $projectId;
    public int $groupId;
    /**
     * @var string One of the EVALUATION_* constants
     */
    public string $evaluation;
    public int $daysInField;
    /**
     * @var int[]
     */
    public array $categoryIds;
    /**
     * @var Locale $locale
     */
    public Locale $locale;
    /**
     * @var string[] One or more of the DEVICE_* constants
     */
    public array $devices;
    /**
     * @var Cell[]
     */
    public array $cells;
    /**
     * @var Filter[][]
     */
    public array $filters;
    /**
     * @var Quota[][]
     */
    public array $quotas;
    /**
     * @var Links $links
     */
    public Links $links;
    public string $created;
    /**
     * @var int[]
     */
    public array $projectExclusions;
    /**
     * @var int[]
     */
    public array $categoryExclusions;
}
