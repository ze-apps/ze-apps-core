<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="breadcrumb">{{ __t("Profile of") }} {{user.firstname+" "+user.lastname}}</div>

<div id="content">
    <h2><i class="fa fa-3x fa-user" aria-hidden="true"></i> {{ __t("My preferences") }}</h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-responsive">
                <thead>
                <tr>
                    <th>{{ __t("First name") }}</th>
                    <th>{{ __t("Last name") }}</th>
                    <th>{{ __t("Email") }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{user.firstname}}</td>
                    <td>{{user.lastname}}</td>
                    <td>{{user.email}}</td>
                    <td>
                        <div class="pull-right">
                            <button type="button" class="btn btn-primary btn-xs" ng-click="edit_profile()">{{ __t("Edit") }}</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-danger" type="button" ng-click="cancel()">{{ __t("Cancel") }}</button>
    </div>

</div>