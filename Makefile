REPO = michalhosna/adminer
ADMINER_VERSION=4.8.1
ADMINER_FLAVOUR=-en
ADMINER_CHECKSUM=4ec36be619bb571e2b5a5d4051bfe06f3fcadb3004969b993f2535f6ce28116b
TAG=$(ADMINER_VERSION)$(ADMINER_FLAVOUR)_v1

all: build publish latest

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
