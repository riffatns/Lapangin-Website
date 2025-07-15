<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Komunitas - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background-color: #1a1a1a;
      color: white;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }
    
    /* Sidebar - Same as dashboard */
    .sidebar {
      width: 250px;
      background-color: #2c2c2e;
      padding: 2rem 0;
      display: flex;
      flex-direction: column;
      border-right: 1px solid #404040;
    }
    
    .logo {
      padding: 0 1.5rem;
      margin-bottom: 3rem;
    }
    
    .logo img {
      height: 32px;
    }
    
    .nav-menu {
      flex: 1;
      padding: 0 1rem;
    }
    
    .nav-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      margin-bottom: 0.5rem;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      color: #999;
      font-weight: 500;
    }
    
    .nav-item:hover {
      background-color: #404040;
      color: white;
    }
    
    .nav-item.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .nav-item .icon {
      margin-right: 0.75rem;
      font-size: 1.1rem;
    }
    
    .user-section {
      padding: 1rem 1.5rem;
      border-top: 1px solid #404040;
    }
    
    .user-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      margin-bottom: 0.5rem;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      color: #999;
      font-weight: 500;
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
    }
    
    .user-item:hover {
      background-color: #404040;
      color: white;
    }
    
    .user-item .icon {
      margin-right: 0.75rem;
      font-size: 1.1rem;
    }
    
    /* Main Content */
    .main-content {
      flex: 1;
      background-color: #1a1a1a;
      overflow-y: auto;
    }
    
    .header {
      background-color: #2c2c2e;
      padding: 1rem 2rem;
      border-bottom: 1px solid #404040;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .header-left h1 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.25rem;
    }
    
    .header-left p {
      color: #999;
      font-size: 0.9rem;
    }
    
    .create-community-btn {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .create-community-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    /* Content */
    .content {
      padding: 2rem;
    }
    
    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }
    
    .stat-card {
      background-color: #2c2c2e;
      padding: 1.5rem;
      border-radius: 12px;
      text-align: center;
      border: 1px solid #404040;
    }
    
    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: #f59e0b;
      margin-bottom: 0.5rem;
    }
    
    .stat-label {
      color: #999;
      font-size: 0.9rem;
    }
    
    /* Tab Navigation */
    .tab-navigation {
      display: flex;
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 0.5rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
    }
    
    .tab-btn {
      flex: 1;
      padding: 0.75rem 1rem;
      background: none;
      border: none;
      color: #999;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .tab-btn.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .tab-btn:hover:not(.active) {
      color: white;
      background-color: #404040;
    }
    
    /* Community Cards */
    .communities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
    }
    
    .community-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid #404040;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .community-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .community-header {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      padding: 1.5rem;
      position: relative;
      overflow: hidden;
    }
    
    .community-header.badminton {
      background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .community-header.futsal {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }
    
    .community-header.tennis {
      background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .community-header.basketball {
      background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    
    .community-sport-icon {
      position: absolute;
      right: 1rem;
      top: 1rem;
      font-size: 2rem;
      opacity: 0.3;
    }
    
    .community-name {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .community-description {
      font-size: 0.9rem;
      opacity: 0.9;
      margin-bottom: 1rem;
    }
    
    .community-stats {
      display: flex;
      gap: 1rem;
    }
    
    .community-stat {
      font-size: 0.8rem;
      opacity: 0.8;
    }
    
    .community-content {
      padding: 1.5rem;
    }
    
    .community-features {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-bottom: 1.5rem;
    }
    
    .feature-tag {
      background-color: #404040;
      color: #999;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.8rem;
    }
    
    .feature-tag.highlight {
      background-color: #f59e0b;
      color: white;
    }
    
    .community-actions {
      display: flex;
      gap: 0.75rem;
    }
    
    .action-btn {
      flex: 1;
      padding: 0.75rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      text-align: center;
      font-size: 0.9rem;
    }
    
    .btn-primary {
      background-color: #f59e0b;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #d97706;
    }
    
    .btn-secondary {
      background-color: #404040;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #525252;
    }
    
    /* User Ranking Section */
    .ranking-section {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
    }
    
    .ranking-header {
      display: flex;
      justify-content: between;
      align-items: center;
      margin-bottom: 1.5rem;
    }
    
    .ranking-title {
      font-size: 1.25rem;
      font-weight: 600;
    }
    
    .user-rank {
      display: flex;
      align-items: center;
      padding: 1rem;
      background-color: #1a1a1a;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1px solid #404040;
    }
    
    .rank-number {
      background-color: #f59e0b;
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      margin-right: 1rem;
    }
    
    .user-info {
      flex: 1;
    }
    
    .user-name {
      font-weight: 600;
      margin-bottom: 0.25rem;
    }
    
    .user-level {
      color: #999;
      font-size: 0.8rem;
    }
    
    .user-points {
      color: #f59e0b;
      font-weight: 600;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      
      .nav-item span:not(.icon),
      .user-item span:not(.icon) {
        display: none;
      }
      
      .header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .communities-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="{{ asset('img/Lapangin-White.png') }}" alt="Lapangin">
    </div>
    
    <div class="nav-menu">
      <a href="{{ route('dashboard') }}" class="nav-item">
        <span class="icon">🏠</span>
        <span>Home</span>
      </a>
      <a href="{{ route('pesanan') }}" class="nav-item">
        <span class="icon">📋</span>
        <span>Pesanan</span>
      </a>
      <a href="{{ route('komunitas') }}" class="nav-item active">
        <span class="icon">👥</span>
        <span>Komunitas</span>
      </a>
    </div>
    
    <div class="user-section">
      <a href="{{ route('notifikasi') }}" class="nav-item {{ request()->routeIs('notifikasi') ? 'active' : '' }}">
        <span class="icon">🔔</span>
        <span>Notification</span>
      </a>
      <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
        <span class="icon">👤</span>
        <span>Profile</span>
      </a>
      <form action="{{ url('/logout') }}" method="POST" style="display: inline; width: 100%;">
        @csrf
        <button type="submit" class="user-item" style="background: none; border: none; width: 100%; text-align: left;">
          <span class="icon">🚪</span>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <div class="header-left">
        <h1>Komunitas Olahraga</h1>
        <p>Bergabung dengan komunitas, main bareng, dan raih prestasi!</p>
      </div>
      <a href="#" class="create-community-btn">
        <span>➕</span>
        Buat Komunitas
      </a>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Stats Overview -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-number">{{ $userStats['total_communities'] }}</div>
          <div class="stat-label">Komunitas Diikuti</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">{{ number_format($userStats['total_points']) }}</div>
          <div class="stat-label">Total Poin</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">{{ $userStats['total_matches'] }}</div>
          <div class="stat-label">Match Dimainkan</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">#{{ $userStats['ranking'] }}</div>
          <div class="stat-label">Peringkat Global</div>
        </div>
      </div>

      <!-- User Ranking Section -->
      <div class="ranking-section">
        <div class="ranking-header">
          <h2 class="ranking-title">🏆 Top Players This Week</h2>
        </div>
        @foreach($topPlayers as $index => $player)
        <div class="user-rank">
          <div class="rank-number">{{ $index + 1 }}</div>
          <div class="user-info">
            <div class="user-name">{{ $player->name }}</div>
            <div class="user-level">
              @switch($player->favorite_sport)
                @case('Badminton')
                  🏸 Badminton Master
                  @break
                @case('Futsal')
                  ⚽ Futsal Champion
                  @break
                @case('Tennis')
                  🎾 Tennis Enthusiast
                  @break
                @case('Basketball')
                  🏀 Basketball Pro
                  @break
                @default
                  � Sports Enthusiast
              @endswitch
            </div>
          </div>
          <div class="user-points">{{ number_format($player->total_points) }} pts</div>
        </div>
        @endforeach
      </div>

      <!-- Tab Navigation -->
      <div class="tab-navigation">
        <button class="tab-btn active" data-tab="all">Semua Komunitas</button>
        <button class="tab-btn" data-tab="my">Komunitas Saya</button>
        <button class="tab-btn" data-tab="play">Main Bareng</button>
        <button class="tab-btn" data-tab="tournament">Tournament</button>
      </div>

      <!-- Communities Grid -->
      <div class="communities-grid" id="communities-grid">
        <!-- Communities Tab Content -->
        <div class="tab-content" data-tab="all">
          @foreach($communities as $community)
          <div class="community-card" data-type="all {{ $community->is_member ? 'my' : '' }}">
            <div class="community-header {{ strtolower($community->sport->name) }}">
              <div class="community-sport-icon">
                @switch($community->sport->name)
                  @case('Badminton')
                    🏸
                    @break
                  @case('Futsal')
                    ⚽
                    @break
                  @case('Tennis')
                    🎾
                    @break
                  @case('Basketball')
                    🏀
                    @break
                  @case('Volleyball')
                    🏐
                    @break
                  @default
                    🏅
                @endswitch
              </div>
              <div class="community-name">{{ $community->name }}</div>
              <div class="community-description">{{ $community->description }}</div>
              <div class="community-stats">
                <span class="community-stat">👥 {{ $community->members_count ?? 0 }} members</span>
                <span class="community-stat">🏆 Level {{ $community->level ?? 1 }}</span>
              </div>
            </div>
            <div class="community-content">
              <div class="community-features">
                @if($community->features)
                  @foreach(explode(',', $community->features) as $feature)
                    <span class="feature-tag {{ $loop->first ? 'highlight' : '' }}">{{ trim($feature) }}</span>
                  @endforeach
                @else
                  <span class="feature-tag highlight">General</span>
                @endif
              </div>
              <div class="community-actions">
                @if($community->is_member)
                  <form action="{{ route('community.leave', $community) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-btn btn-secondary">Keluar</button>
                  </form>
                @else
                  <form action="{{ route('community.join', $community) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-btn btn-primary">Gabung</button>
                  </form>
                @endif
                <a href="#" class="action-btn btn-secondary">Detail</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- My Communities Tab Content -->
        <div class="tab-content" data-tab="my" style="display: none;">
          @foreach($communities->where('is_member', true) as $community)
          <div class="community-card">
            <div class="community-header {{ strtolower($community->sport->name) }}">
              <div class="community-sport-icon">
                @switch($community->sport->name)
                  @case('Badminton')
                    🏸
                    @break
                  @case('Futsal')
                    ⚽
                    @break
                  @case('Tennis')
                    🎾
                    @break
                  @case('Basketball')
                    🏀
                    @break
                  @case('Volleyball')
                    🏐
                    @break
                  @default
                    🏅
                @endswitch
              </div>
              <div class="community-name">{{ $community->name }}</div>
              <div class="community-description">{{ $community->description }}</div>
              <div class="community-stats">
                <span class="community-stat">👥 {{ $community->members_count ?? 0 }} members</span>
                <span class="community-stat">🏆 Level {{ $community->level ?? 1 }}</span>
              </div>
            </div>
            <div class="community-content">
              <div class="community-features">
                @if($community->features)
                  @foreach(explode(',', $community->features) as $feature)
                    <span class="feature-tag {{ $loop->first ? 'highlight' : '' }}">{{ trim($feature) }}</span>
                  @endforeach
                @else
                  <span class="feature-tag highlight">General</span>
                @endif
              </div>
              <div class="community-actions">
                <form action="{{ route('community.leave', $community) }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="action-btn btn-secondary">Keluar</button>
                </form>
                <a href="#" class="action-btn btn-secondary">Detail</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Play Together Tab Content -->
        <div class="tab-content" data-tab="play" style="display: none;">
          @foreach($playTogethers as $playTogether)
          <div class="community-card">
            <div class="community-header {{ strtolower($playTogether->sport->name) }}">
              <div class="community-sport-icon">
                @switch($playTogether->sport->name)
                  @case('Badminton')
                    🏸
                    @break
                  @case('Futsal')
                    ⚽
                    @break
                  @case('Tennis')
                    🎾
                    @break
                  @case('Basketball')
                    🏀
                    @break
                  @case('Volleyball')
                    🏐
                    @break
                  @default
                    🏅
                @endswitch
              </div>
              <div class="community-name">{{ $playTogether->title }}</div>
              <div class="community-description">{{ $playTogether->description }}</div>
              <div class="community-stats">
                <span class="community-stat">👥 {{ $playTogether->current_participants }}/{{ $playTogether->max_participants }}</span>
                <span class="community-stat">📅 {{ $playTogether->formatted_scheduled_date }}</span>
                <span class="community-stat">⏰ {{ $playTogether->formatted_scheduled_time }}</span>
              </div>
            </div>
            <div class="community-content">
              <div class="community-features">
                <span class="feature-tag highlight">{{ $playTogether->skill_level ?? 'All Levels' }}</span>
                @if($playTogether->venue)
                  <span class="feature-tag">📍 {{ $playTogether->venue->name }}</span>
                @else
                  <span class="feature-tag">📍 {{ $playTogether->location }}</span>
                @endif
                @if($playTogether->price_per_person > 0)
                  <span class="feature-tag">💰 Rp {{ number_format($playTogether->price_per_person, 0, ',', '.') }}</span>
                @else
                  <span class="feature-tag">🆓 Gratis</span>
                @endif
              </div>
              <div class="community-actions">
                @if($playTogether->is_participant)
                  <form action="{{ route('play-together.leave', $playTogether) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-btn btn-secondary">Keluar</button>
                  </form>
                @else
                  @if($playTogether->is_full)
                    <button class="action-btn btn-secondary" disabled>Penuh</button>
                  @else
                    <form action="{{ route('play-together.join', $playTogether) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="action-btn btn-primary">Gabung</button>
                    </form>
                  @endif
                @endif
                <a href="#" class="action-btn btn-secondary">Detail</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Tournament Tab Content -->
        <div class="tab-content" data-tab="tournament" style="display: none;">
          @foreach($tournaments as $tournament)
          <div class="community-card">
            <div class="community-header {{ strtolower($tournament->sport->name) }}">
              <div class="community-sport-icon">
                @switch($tournament->sport->name)
                  @case('Badminton')
                    🏸
                    @break
                  @case('Futsal')
                    ⚽
                    @break
                  @case('Tennis')
                    🎾
                    @break
                  @case('Basketball')
                    🏀
                    @break
                  @case('Volleyball')
                    🏐
                    @break
                  @default
                    🏅
                @endswitch
              </div>
              <div class="community-name">{{ $tournament->name }}</div>
              <div class="community-description">{{ $tournament->description }}</div>
              <div class="community-stats">
                <span class="community-stat">👥 {{ $tournament->current_participants }}/{{ $tournament->max_participants }}</span>
                <span class="community-stat">📅 {{ $tournament->formatted_start_date }}</span>
                <span class="community-stat">⏰ Daftar sampai: {{ $tournament->formatted_registration_deadline }}</span>
                @if($tournament->prize_pool > 0)
                  <span class="community-stat">🏆 Rp {{ number_format($tournament->prize_pool, 0, ',', '.') }}</span>
                @endif
              </div>
            </div>
            <div class="community-content">
              <div class="community-features">
                <span class="feature-tag highlight">{{ $tournament->tournament_type ?? 'Tournament' }}</span>
                <span class="feature-tag">🎯 {{ $tournament->skill_level ?? 'All Levels' }}</span>
                @if($tournament->venue)
                  <span class="feature-tag">📍 {{ $tournament->venue->name }}</span>
                @else
                  <span class="feature-tag">📍 {{ $tournament->location }}</span>
                @endif
                @if($tournament->entry_fee > 0)
                  <span class="feature-tag">💰 Rp {{ number_format($tournament->entry_fee, 0, ',', '.') }}</span>
                @else
                  <span class="feature-tag">🆓 Gratis</span>
                @endif
                @if($tournament->status === 'registration_open')
                  <span class="feature-tag highlight">🔓 Pendaftaran Terbuka</span>
                @elseif($tournament->status === 'registration_closed')
                  <span class="feature-tag">🔒 Pendaftaran Ditutup</span>
                @endif
              </div>
              <div class="community-actions">
                @if($tournament->is_participant)
                  <form action="{{ route('tournament.unregister', $tournament) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-btn btn-secondary">Batal</button>
                  </form>
                @else
                  @if(!$tournament->is_registration_open)
                    <button class="action-btn btn-secondary" disabled>
                      @if($tournament->is_full) Penuh @else Ditutup @endif
                    </button>
                  @else
                    <form action="{{ route('tournament.register', $tournament) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="action-btn btn-primary">Daftar</button>
                    </form>
                  @endif
                @endif
                <a href="#" class="action-btn btn-secondary">Detail</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
      const tabBtns = document.querySelectorAll('.tab-btn');
      const tabContents = document.querySelectorAll('.tab-content');
      
      tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          // Remove active class from all tabs
          tabBtns.forEach(tab => tab.classList.remove('active'));
          // Add active class to clicked tab
          this.classList.add('active');
          
          const activeTab = this.dataset.tab;
          
          // Hide all tab contents
          tabContents.forEach(content => {
            content.style.display = 'none';
          });
          
          // Show active tab content
          const activeContent = document.querySelector(`.tab-content[data-tab="${activeTab}"]`);
          if (activeContent) {
            activeContent.style.display = 'grid';
          }
        });
      });

      // Set initial display style for grid
      const allTabContent = document.querySelector('.tab-content[data-tab="all"]');
      if (allTabContent) {
        allTabContent.style.display = 'grid';
      }
    });
  </script>
</body>
</html>