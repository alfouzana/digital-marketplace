<?php

function approval_lang($status)
{
    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::PENDING) {
        return __('pending');
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::APPROVED) {
        return __('approved');
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::REJECTED) {
        return __('rejected');
    }
}


function approval_context($status)
{
    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::PENDING) {
        return 'warning';
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::APPROVED) {
        return 'success';
    }

    if ($status === \Mtvs\EloquentApproval\ApprovalStatuses::REJECTED) {
        return 'danger';
    }
}
