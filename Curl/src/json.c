#include "../includes/json.h"

size_t writeCallback(char *ptr, size_t size, size_t nmemb, void *userdata)
{

    // Calculate the actual size of the data
    size_t realSize = size * nmemb;

    char *responseStr = (char *)userdata;

    // Add the new data to the end of the string
    strcat(responseStr, ptr);

    return realSize;
}

json_t *getValueFromJson(json_t *root, const char *key)
{
    if (!json_is_object(root))
    {
        fprintf(stderr, "Le JSON fourni n'est pas un objet.\n");
        return NULL;
    }

    json_t *value = NULL;
    const char *objKey;

    json_object_foreach(root, objKey, value)
    {
        if (strcmp(key, objKey) == 0)
        {
            return value;
        }
        else if (json_is_object(value))
        {
            json_t *innerValue = getValueFromJson(value, key);
            if (innerValue != NULL)
            {
                return innerValue;
            }
        }
        else if (json_is_array(value))
        {
            size_t arrSize = json_array_size(value);
            for (size_t i = 0; i < arrSize; i++)
            {
                json_t *innerValue = getValueFromJson(json_array_get(value, i), key);
                if (innerValue != NULL)
                {
                    return innerValue;
                }
            }
        }
    }

    return NULL;
}
