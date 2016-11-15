<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ trans('messages.dynmarket') }}</span>
    </div>
    <div class="padding-15">
        <div class="row">
            @foreach($dynmarket as $product)
                @if($product[1] != 0)
                    <div class="col-md-6">
                        <strong>{{ transd('products.'.$product[0], $product[0]) }}</strong>
                        <span class="pull-right">{{ \Formatter::money($product[1]) }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>