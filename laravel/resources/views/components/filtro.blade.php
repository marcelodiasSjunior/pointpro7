<ul class="nav nav-tabs" id="myIconTab" role="tablist">
                    <li class="nav-item">
                      <a
                        class="nav-link active"
                        id="home-icon-tab"
                        data-bs-toggle="tab"
                        href="#homeIcon"
                        role="tab"
                        aria-controls="homeIcon"
                        aria-selected="true"
                        ><i class="nav-icon i-Stopwatch me-1"></i>{{ $dayDiffHumans }} <span class="badge bg-primary margin-label-2">{{ $dayOfWeekName }}</span><span class="badge bg-primary margin-label-2">{{ $dayOfWeekHuman }}</span></a
                      >
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        id="profile-icon-tab"
                        data-bs-toggle="tab"
                        href="#profileIcon"
                        role="tab"
                        aria-controls="profileIcon"
                        aria-selected="false"
                        ><i class="nav-icon i-Calendar-4 me-1"></i> Histórico</a
                      >
                    </li>
                  </ul>