<div class="navigation-bar">
    <div class="logo">
         <img src="{{ asset('/assets/images/logo.png') }}" alt="Logo">
    </div>
    <nav>
        {{-- <a href="{{ route('dashboard') }}">Dashboard</a> --}}
        <a href="{{ route('profile') }}">Profile</a>
    </nav>

    {{-- <nav>
        <h6>Users</h6>
        <div class="childNav">
            <a href ="{{ route('admin.user.list') }}">Users</a>
            <a href ="{{ route('admin.wallet.list') }}">Wallet</a>
            <a href ="">Payments</a>
        </div>
    </nav> --}}
    {{-- <nav>
        <a href ="{{ route('admin.blog.list') }}">Blog</a>
    </nav> --}}
    {{-- <nav>
        <h6>Report</h6>
        <div class="reportNav childNav">
            <a href ="{{ route('admin.report.images.view') }}">Images</a>
            <a href ="{{ route('admin.report.submissions.view') }}">Submissions</a>
            <a href ="{{ route('admin.report.users.view') }}">User</a>
        </div>
    </nav>
    <nav>
        <a href="{{ route('admin.support.view') }}">Support Tickets</a>
    </nav> --}}
</div>