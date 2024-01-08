<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Planning </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('planning.machine-yearly.index') }}">
                ปรับแผนการผลิตประจำปี
            </a>
        </li>
        <li><a href="{{ route('planning.machine-biweekly.index') }}">
                ปรับแผนการผลิตประจำปักษ์
            </a>
        </li>
        <li>
            <a href="{{ route('planning.production-biweekly.show', -1) }}">
                ประมาณการแผนรายปักษ์
            </a>
        </li>

        <li>
            <a href="{{ route('planning.adjusts.show', -1) }}">
                ปรับแผนการผลิตประจำปักษ์
            </a>
        </li>

        <li>
            <a href="{{ route('planning.follow-ups.index') }}">
                ติดตามแผนการผลิตประจำปักษ์
            </a>
        </li>
        
        <li>
            <a href="{{ route('planning.production-daily.show', -1) }}">
                ประมาณการผลิตรายวัน
            </a>
        </li>
    </ul>
</li>


