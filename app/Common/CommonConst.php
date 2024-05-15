<?php

namespace App\Common;

class CommonConst
{
    // Status const
    const ACTIVE = 1;
    const IN_ACTIVE = 0;
    const USER_IS_NOT_ACTIVE = 0; // not verify email
    const USER_IS_ACTIVE = 1;
    const USER_IS_DE_ACTIVE = 2;
    // End status const

    const MAXIMUM_SIZE_AVATAR = 2048;
    const MAXIMUM_SIZE_FILE_UPLOAD = 1048576;
    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;
    const GENDER_OTHER = 2;
    const UPDATE_METHOD = ['PUT', 'PATCH'];
    const LOCAL_STORAGE = 'public';
    const DIRECTORY_SEPARATOR = '/';
    const TOKEN_TYPE_AUTH = 'auth';

    // Start action const
    const LOGIN = 'login';
    const LOGOUT = 'logout';
    const INDEX = 'index';
    const SHOW = 'show';
    const DETAIL = 'detail';
    const CREATE = 'create';
    const STORE = 'store';
    const UPDATE = 'update';
    const UPDATE_STATUS = 'update_status';
    const REMOVE = 'remove';
    const DELETE = 'delete';
    const COMMENT = 'comment';
    const REJECT = 'reject';
    const CONFIRM = 'confirm';

    // End action const
    const TIME_EXPIRED_FORGOT_PASSWORD_LINK_MINUTES = 30;
    const TIME_EXPIRED_DEFAULT_OF_LINK_IN_MINUTES = 30;
    // Date, time, etc
    const SECOND = 'second';
    const MINUTE = 'minute';
    const HOUR = 'hour';
    const DAY = 'day';
    // End data, time, etc ,...
    const RESET_PWD_LINK_EXPIRED_IN_MINUTE = 30;

    const DEFAULT_PER_PAGE = 10;

    // Order constant
    const ORDER_TYPE_ASC = 'asc';
    const ORDER_TYPE_DESC = 'desc';

    const DISABLED = 1;
    const UNDISABLED = 0;
}
