<div class="activity-box">
    <h4 class="m-l-xs">Activities</h4>
    <div class="ibox-content p-xs">
        <div class="feed-activity-list">
            @foreach($activityLogs->sortByDesc('creation_date')->all() as $activityLog)
            <div class="feed-element">
                <div class="media-body ">
                    <div class="pull-right text-right">
                        <small>
                            {{ timeElapsedString($activityLog->creation_date) }}
                        </small>
                    </div>
                    <div>
                        <strong>{{ $activityLog->user->name }}</strong> : <span>{{ $activityLog->title }}</span>
                    </div>
                    <div>
                        <small class="text-muted">
                            {{ date(trans('date.time-format'),strtotime($activityLog->creation_date)) }}
                        </small>
                    </div>
                    @if($activityLog->description)
                        <div class="well mini-scroll-bar" style="max-height: 100px;overflow: auto;">
                            {!! nl2br(e($activityLog->description)) !!}
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
