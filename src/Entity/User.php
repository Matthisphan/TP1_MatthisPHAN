<?php

namespace App\Entity;

use App\Enum\UserAccountStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(enumType: UserAccountStatusEnum::class)]
    private ?UserAccountStatusEnum $accountStatus = UserAccountStatusEnum::INACTIVE;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Subscription $currentSubscription = null;

    // Collections
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'publisher')]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: SubscriptionHistory::class, mappedBy: 'subscriber')]
    private Collection $subscriptionHistories;

    #[ORM\OneToMany(targetEntity: PlaylistSubscription::class, mappedBy: 'subscriber')]
    private Collection $playlistSubscriptions;

    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'creator')]
    private Collection $playlists;

    #[ORM\OneToMany(targetEntity: WatchHistory::class, mappedBy: 'watcher')]
    private Collection $watchHistories;

    #[ORM\Column]
    private array $roles = [];

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->subscriptionHistories = new ArrayCollection();
        $this->playlistSubscriptions = new ArrayCollection();
        $this->playlists = new ArrayCollection();
        $this->watchHistories = new ArrayCollection();
        $this->roles = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getAccountStatus(): ?UserAccountStatusEnum
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(UserAccountStatusEnum $accountStatus): static
    {
        $this->accountStatus = $accountStatus;
        return $this;
    }

    public function getCurrentSubscription(): ?Subscription
    {
        return $this->currentSubscription;
    }

    public function setCurrentSubscription(?Subscription $currentSubscription): static
    {
        $this->currentSubscription = $currentSubscription;
        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPublisher($this);
        }
        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getPublisher() === $this) {
                $comment->setPublisher(null);
            }
        }
        return $this;
    }

    public function getSubscriptionHistories(): Collection
    {
        return $this->subscriptionHistories;
    }

    public function addSubscriptionHistory(SubscriptionHistory $subscriptionHistory): static
    {
        if (!$this->subscriptionHistories->contains($subscriptionHistory)) {
            $this->subscriptionHistories->add($subscriptionHistory);
            $subscriptionHistory->setSubscriber($this);
        }
        return $this;
    }

    public function removeSubscriptionHistory(SubscriptionHistory $subscriptionHistory): static
    {
        if ($this->subscriptionHistories->removeElement($subscriptionHistory)) {
            if ($subscriptionHistory->getSubscriber() === $this) {
                $subscriptionHistory->setSubscriber(null);
            }
        }
        return $this;
    }

    public function getPlaylistSubscriptions(): Collection
    {
        return $this->playlistSubscriptions;
    }

    public function addPlaylistSubscription(PlaylistSubscription $playlistSubscription): static
    {
        if (!$this->playlistSubscriptions->contains($playlistSubscription)) {
            $this->playlistSubscriptions->add($playlistSubscription);
            $playlistSubscription->setSubscriber($this);
        }
        return $this;
    }

    public function removePlaylistSubscription(PlaylistSubscription $playlistSubscription): static
    {
        if ($this->playlistSubscriptions->removeElement($playlistSubscription)) {
            if ($playlistSubscription->getSubscriber() === $this) {
                $playlistSubscription->setSubscriber(null);
            }
        }
        return $this;
    }

    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setCreator($this);
        }
        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            if ($playlist->getCreator() === $this) {
                $playlist->setCreator(null);
            }
        }
        return $this;
    }

    public function getWatchHistories(): Collection
    {
        return $this->watchHistories;
    }

    public function addWatchHistory(WatchHistory $watchHistory): static
    {
        if (!$this->watchHistories->contains($watchHistory)) {
            $this->watchHistories->add($watchHistory);
            $watchHistory->setWatcher($this);
        }
        return $this;
    }

    public function removeWatchHistory(WatchHistory $watchHistory): static
    {
        if ($this->watchHistories->removeElement($watchHistory)) {
            if ($watchHistory->getWatcher() === $this) {
                $watchHistory->setWatcher(null);
            }
        }
        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getRoles(): array
    {
        return $this->roles ?: ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
