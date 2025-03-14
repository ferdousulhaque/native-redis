<?php
namespace NativeSupport\PHPRedis;

enum ErrorMessages: string
{
    case CONNECTION_FAILED = "Could not connect to Redis using the provided connector.";
    case CONNECTION_ERROR = "Redis connection error: ";
    case SET_FAILED = "Failed to set key '%s': ";
    case GET_FAILED = "Failed to get key '%s': ";
    case INCR_FAILED = "Failed to increment key '%s': ";
    case DEL_FAILED = "Failed to delete keys: %s - ";
    case SEARCH_FAILED = "Redisearch failed for index '%s': ";
    case PIPELINE_FAILED = "Pipeline execution failed: ";
    case HMGET_FAILED = "Failed to get hash fields from '%s': ";
    case HSET_FAILED = "Failed to set hash field in '%s': ";
    case HGETALL_FAILED = "Failed to get all fields from hash '%s': ";
    case DBSIZE_FAILED = "Failed to get database size: ";
    case PUSH_FAILED = "Failed to push to list '%s': ";
    case POP_FAILED = "Failed to pop from list '%s': ";
}
