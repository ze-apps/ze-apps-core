<div id="breadcrumb">Ze-apps > Config</div>
<div id="content">


    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary" ng-click="emptyCache()">{{ __t("Clear cache") }}</button>
        </div>
    </div>

    <form>

        <div class="row">
            <div class="col-md-12">
                <h3>{{ __t("Application options") }}</h3>
                <div class="input-group">
                    <label>
                        <input type="checkbox" ng-model="$root.debug">
                        {{ __t("Debug Mode") }}
                    </label>
                </div>
            </div>
        </div>

        <form-buttons></form-buttons>

    </form>
</div>
