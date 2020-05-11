REPO = michalhosna/adminer
ADMINER_VERSION=4.7.7
ADMINER_FLAVOUR=-en
ADMINER_CHECKSUM=8b05028901fc7dc486cefcf660c103ceb27f588fcbde2952d31264584a4384ab
TAG=$(ADMINER_VERSION)$(ADMINER_FLAVOUR)_v1

all: build publish

build:
	docker build \
		--build-arg ADMINER_VERSION=$(ADMINER_VERSION) \
		--build-arg ADMINER_CHECKSUM=$(ADMINER_CHECKSUM) \
		--build-arg ADMINER_FLAVOUR=$(ADMINER_FLAVOUR) \
		-t $(REPO):$(TAG) \
		src

publish:
	docker push $(REPO):$(TAG)

latest:
	docker tag $(REPO):$(TAG) $(REPO):latest
	docker push $(REPO):latest

.PHONY: all build publish
