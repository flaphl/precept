<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Mapping\Builder;

/**
 * Fluent builder for entity listener metadata.
 */
class EntityListenerBuilder
{
    private array $listeners = [];

    public function __construct(
        private readonly ClassMetaDataBuilder $classMetadataBuilder
    ) {
    }

    /**
     * Add a PrePersist listener.
     */
    public function addPrePersist(string $method): self
    {
        $this->listeners['prePersist'][] = $method;

        return $this;
    }

    /**
     * Add a PostPersist listener.
     */
    public function addPostPersist(string $method): self
    {
        $this->listeners['postPersist'][] = $method;

        return $this;
    }

    /**
     * Add a PreUpdate listener.
     */
    public function addPreUpdate(string $method): self
    {
        $this->listeners['preUpdate'][] = $method;

        return $this;
    }

    /**
     * Add a PostUpdate listener.
     */
    public function addPostUpdate(string $method): self
    {
        $this->listeners['postUpdate'][] = $method;

        return $this;
    }

    /**
     * Add a PreRemove listener.
     */
    public function addPreRemove(string $method): self
    {
        $this->listeners['preRemove'][] = $method;

        return $this;
    }

    /**
     * Add a PostRemove listener.
     */
    public function addPostRemove(string $method): self
    {
        $this->listeners['postRemove'][] = $method;

        return $this;
    }

    /**
     * Add a PostLoad listener.
     */
    public function addPostLoad(string $method): self
    {
        $this->listeners['postLoad'][] = $method;

        return $this;
    }

    /**
     * Add a PreFlush listener.
     */
    public function addPreFlush(string $method): self
    {
        $this->listeners['preFlush'][] = $method;

        return $this;
    }

    /**
     * Build and return to class metadata builder.
     */
    public function build(): ClassMetaDataBuilder
    {
        $this->classMetadataBuilder->setLifecycleCallbacks($this->listeners);

        return $this->classMetadataBuilder;
    }
}
