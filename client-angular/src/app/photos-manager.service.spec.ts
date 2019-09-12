import { TestBed } from '@angular/core/testing';

import { PhotosManagerService } from './photos-manager.service';

describe('PhotosManagerService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: PhotosManagerService = TestBed.get(PhotosManagerService);
    expect(service).toBeTruthy();
  });
});
