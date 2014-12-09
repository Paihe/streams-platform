<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class UnassignFieldCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class UnassignFieldCommandHandler
{

    use DispatchableTrait;

    protected $fields;

    protected $streams;

    protected $assignments;

    function __construct(
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams,
        AssignmentRepositoryInterface $assignments
    ) {
        $this->fields      = $fields;
        $this->streams     = $streams;
        $this->assignments = $assignments;
    }

    /**
     * Handle the command.
     *
     * @param UnassignFieldCommand $command
     * @return mixed
     */
    public function handle(UnassignFieldCommand $command)
    {
        $stream = $this->streams->findByNamespaceAndSlug($command->getNamespace(), $command->getStream());
        $field  = $this->fields->findByNamespaceAndSlug($command->getNamespace(), $command->getField());

        return $this->assignments->delete($stream, $field);
    }
}
 