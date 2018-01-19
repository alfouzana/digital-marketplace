<?php

function approval_status($approvable)
{
    if ($approvable->isPending()) {
        return __('Pending');
    }

    if ($approvable->isApproved()) {
        return __('Approved');
    }

    if ($approvable->isRejected()) {
        return __('Rejected');
    }
}


function approval_context($approvable)
{
    if ($approvable->isPending()) {
        return 'warning';
    }

    if ($approvable->isApproved()) {
        return 'success';
    }

    if ($approvable->isRejected()) {
        return 'danger';
    }
}