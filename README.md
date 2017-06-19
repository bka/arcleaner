# ARCleaner

I did not find a way to delete docker images from a private registry hosted on ms azure. Hence, this litte script can connect to the registry to delete all file layer blobs for a given image directly.

    bin/arcleaner delete-image someimage 1.0 --accountName ${ACCOUNT} --accountKey ${KEY} --repository ${REPO} --dry

List existing images:

    bin/arcleaner list-images --accountName ${ACCOUNT} --accountKey ${KEY} --repository ${REPO} --dry
