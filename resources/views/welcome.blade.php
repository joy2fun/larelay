<style>
    .tool-items {
        margin: 1em 0;
        background: #fcfcfc;
        padding: 3em 1em;
    }

    .tool-items .item {
        margin: 1em 0;
        padding: 1em 0;
        display: block;
        position: relative;
    }

    .tool-items .item:hover {
        background: #f8f8f8;
        left: 2px;
        top: 2px;
    }

    .tool-items .icon {
        font-size: 3em;
        opacity: .9;
        color: #4c60a3;
    }
</style>

<div class="row text-center tool-items">
    <div class="col-4">
        <a class="item" href="{{admin_url('endpoints')}}">
            <div class="icon"><i class="fa feather icon-circle"></i></div>
            <div class="text">Endpoints</div>
        </a>
    </div>
    <div class="col-4">
        <a class="item" href="{{admin_url('endpoints-targets')}}">
            <div class="icon"><i class="fa feather icon-external-link"></i></div>
            <div class="text">Targets</div>
        </a>
    </div>
    <div class="col-4">
        <a class="item" target="_blank" href="{{config('telescope.path')}}">
            <div class="icon"><i class="fa fa-bug"></i></div>
            <div class="text">Telescope</div>
        </a>
    </div>
    <div class="col-4">
        <a class="item" href="{{admin_url('auth/logout')}}">
            <div class="icon"><i class="fa fa-sign-out"></i></div>
            <div class="text">Logout</div>
        </a>
    </div>
</div>