# How to contribute?

This library is fully open source and contributions are very welcome. To make things easy for maintainers there are a few guidelines to contribute.

## 1. Use a fork and clear branch name 
New contributions are developed on a own branch. If you have a great idea that requires a million lines of code this will not block other contributors to implement their ideas.

## 2. Use the PSR-2 coding guidelines
When you are developing please use the PSR-2 coding guidelines. Using these will improve code quality. If you're in doubt about a certain guideline you can always use the command `make cs` to fix all coding errors.

## 3. Always merge to develop-branch
If you have a certain idea ready and it's ready to merge, please merge to develop. the develop-branch is the branch where all new things happen. New things also include bugs. This creates a safe playground for new features.

## 4. (For maintainers) Adding a new feature to master
If a new feature is added and is proven to be free of bugs, the feature is ready for being added to master branch. This is done by cherry-picking the relevant merge commits in develop. Only use 1 cherry-pick commit. This commit will also have a commit message that involve the added feature. An example could be "Added feature: blow up the server room". The detailed commit message will mention the contributors and some extra data on the feature.
Using this scheme makes that new finished features are available into the master branch before they are released with a new version.

## 5. (For maintainers) What are version numbers?
Every now and then a new version is released. The version tag has a major.minor(.bugfix) scheme.
A new major version involves a big new feature that cannot be unseen or it includes a major overhaul of the code base resulting in a lot of breaking changes.

A new minor version involves several changes and new additions. This can be bugfixes or new features. They are released when the maintainers feel this is a good time. They may include breaking changes.

A Bugfix release can be released after any release. Bugfix releases are releases that only include bugfixes. They fix a severe bug in the software that should be fixed immediately.